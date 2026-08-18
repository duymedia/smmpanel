<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Thư mục lưu file backup zip
     */
    private function backupPath(): string
    {
        return storage_path('app/backups');
    }

    public function index()
    {
        $path = $this->backupPath();
        $files = [];

        if (is_dir($path)) {
            foreach (glob($path . '/*.zip') as $file) {
                $name = basename($file);
                $files[] = [
                    'name'    => $name,
                    'size'    => round(filesize($file) / 1048576, 2) . ' MB',
                    'created' => date('Y-m-d H:i:s', filemtime($file)),
                ];
            }
            // Sắp xếp mới nhất lên đầu
            usort($files, fn($a, $b) => strcmp($b['created'], $a['created']));
        }

        return view('adminpanel.backup.index', compact('files'));
    }

    /**
     * Download file zip backup
     */
    public function download(Request $request)
    {
        $filename = $request->input('file');

        // Validate tên file: chỉ cho phép YYYY-MM.zip
        if (!preg_match('/^\d{4}-\d{2}\.zip$/', $filename)) {
            abort(400, 'Invalid file name');
        }

        $filePath = $this->backupPath() . '/' . $filename;

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath);
    }

    /**
     * Export orders của tháng ra file Excel (.xlsx thực ra là CSV UTF-8 BOM mở được bằng Excel)
     * Format: Order ID;Account;Service;Link;Quantity;Remains;Charge;Provider Charge;Status;Created;Changed
     */
    public function exportExcel(Request $request)
    {
        $filename = $request->input('file');

        // Validate: YYYY-MM.zip
        if (!preg_match('/^(\d{4})-(\d{2})\.zip$/', $filename, $m)) {
            abort(400, 'Invalid file name');
        }

        $year  = $m[1];
        $month = $m[2];

        $orders = Order::with(['user', 'service'])
            ->where('domain', getDomain())
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id')
            ->get();

        $csvName = "{$year}-{$month}-orders.csv";

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$csvName}\"",
        ];

        $callback = function () use ($orders) {
            $out = fopen('php://output', 'w');

            // UTF-8 BOM để Excel nhận diện đúng encoding
            fwrite($out, "\xEF\xBB\xBF");

            // Header row
            fputcsv($out, [
                'Order ID', 'Account', 'Service', 'Link',
                'Quantity', 'Remains', 'Charge', 'Provider Charge',
                'Status', 'Created', 'Changed',
            ], ';');

            foreach ($orders as $order) {
                fputcsv($out, [
                    $order->id,
                    $order->user?->username ?? $order->user_id,
                    $order->service_id,
                    $order->link,
                    $order->quantity,
                    $order->remains ?? 0,
                    number_format($order->charge ?? 0, 10, '.', ''),
                    number_format($order->total ?? 0, 10, '.', ''),
                    ucfirst($order->status),
                    $order->created_at?->format('Y-m-d H:i:s') ?? '',
                    $order->updated_at?->format('Y-m-d H:i:s') ?? '',
                ], ';');
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
