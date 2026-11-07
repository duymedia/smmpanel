<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class HeleketCheckoutService
{
    private const ENDPOINT = 'https://api.heleket.com/v1/payment';

    public function createCheckout(array $credentials, array $payment): array
    {
        $merchant = trim((string) ($credentials['merchant'] ?? $credentials['merchant_id'] ?? ''));
        $apiKey = trim((string) ($credentials['payment_api_key'] ?? $credentials['api_key'] ?? ''));

        if ($merchant === '' || $apiKey === '') {
            return $this->failure('Heleket merchant ID and payment API key are required.', 422);
        }

        $amount = trim((string) ($payment['amount'] ?? ''));
        $currency = strtoupper(trim((string) ($payment['currency'] ?? '')));
        $orderId = trim((string) ($payment['order_id'] ?? ''));

        if (!is_numeric($amount) || (float) $amount <= 0 || $currency === '' || !preg_match('/^[A-Za-z0-9_-]{1,128}$/', $orderId)) {
            return $this->failure('A positive amount, currency, and valid order_id are required.', 422);
        }

        $payload = [
            'amount' => $amount,
            'currency' => $currency,
            'order_id' => $orderId,
        ];

        foreach ([
            'network', 'to_currency', 'url_return', 'url_success', 'url_callback',
            'additional_data', 'payer_email', 'theme', 'course_source',
        ] as $key) {
            if (isset($payment[$key]) && $payment[$key] !== '') {
                $payload[$key] = $payment[$key];
            }
        }

        foreach (['lifetime', 'subtract', 'accuracy_payment_percent'] as $key) {
            if (isset($payment[$key]) && $payment[$key] !== '') {
                $payload[$key] = $payment[$key];
            }
        }

        foreach (['is_payment_multiple', 'is_refresh'] as $key) {
            if (array_key_exists($key, $payment)) {
                $payload[$key] = (bool) $payment[$key];
            }
        }

        foreach (['currencies', 'except_currencies'] as $key) {
            if (isset($payment[$key]) && is_array($payment[$key])) {
                $payload[$key] = $payment[$key];
            }
        }

        try {
            $body = json_encode($payload, JSON_THROW_ON_ERROR);
            $signature = md5(base64_encode($body) . $apiKey);

            $response = Http::connectTimeout(5)
                ->timeout(20)
                ->withHeaders([
                    'merchant' => $merchant,
                    'sign' => $signature,
                    'Content-Type' => 'application/json',
                ])
                ->withBody($body, 'application/json')
                ->post(self::ENDPOINT);

            $data = $response->json();
            if (!$response->successful() || !is_array($data) || (int) ($data['state'] ?? 1) !== 0) {
                $errors = is_array($data) ? ($data['errors'] ?? null) : null;
                $errorText = is_array($errors)
                    ? collect($errors)->map(static fn ($messages, $field) => $field . ': ' . implode(', ', (array) $messages))->implode('; ')
                    : null;
                $message = is_array($data)
                    ? ($data['message'] ?? $data['error'] ?? $errorText)
                    : null;
                $message = is_string($message) && $message !== ''
                    ? $message
                    : 'Heleket returned an invalid response (HTTP ' . $response->status() . '). Verify the Merchant ID and Payment API key.';

                Log::warning('Heleket invoice request rejected', [
                    'http_status' => $response->status(),
                    'state' => is_array($data) ? ($data['state'] ?? null) : null,
                    'message' => $message,
                    'errors' => $errors,
                ]);

                return $this->failure(
                    $message,
                    $response->status() >= 400 ? 502 : 422,
                    $errors
                );
            }

            $invoice = $data['result'] ?? [];
            $checkoutUrl = $invoice['url'] ?? null;
            if (!is_string($checkoutUrl) || !filter_var($checkoutUrl, FILTER_VALIDATE_URL)) {
                return $this->failure('Heleket response did not include a valid checkout URL.', 502);
            }

            return [
                'success' => true,
                'checkout_url' => $checkoutUrl,
                'invoice_uuid' => $invoice['uuid'] ?? null,
                'order_id' => $invoice['order_id'] ?? $orderId,
                'invoice' => $invoice,
            ];
        } catch (Throwable $exception) {
            report($exception);
            return $this->failure('Could not connect to Heleket.', 502);
        }
    }

    private function failure(string $message, int $status, mixed $details = null): array
    {
        return array_filter([
            'success' => false,
            'http_status' => $status,
            'error' => $message,
            'details' => $details,
        ], static fn ($value) => $value !== null);
    }
}
