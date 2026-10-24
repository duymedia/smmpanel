<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Carbon\Carbon;

class BackupController extends Controller
{
    private function backupPath(): string
    {
        return storage_path('app/backups');
    }

    /**
     * Hiển thị danh sách các tháng có thể backup
     */
    public function index()
    {
        $domain = getDomain();
        $files = [];

        // Tìm tháng có order đầu tiên
        $firstOrder = Order::where('domain', $domain)->orderBy('created_at')->first();

        if ($firstOrder) {
            $startMonth = Carbon::parse($firstOrder->created_at)->startOfMonth();
            $endMonth = now()->subMonth()->startOfMonth();

            $current = $endMonth->copy();
            while ($current->gte($startMonth)) {
                $year = $current->format('Y');
                $month = $current->format('m');
                $zipName = "{$domain}_{$year}-{$month}.zip";

                // Kiểm tra số orders trong tháng
                $orderCount = Order::where('domain', $domain)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->count();

                // Kiểm tra file zip đã tồn tại chưa
                $zipPath = $this->backupPath() . '/' . $zipName;
                $fileExists = file_exists($zipPath);

                $files[] = [
                    'name'       => $zipName,
                    'size'       => $fileExists ? round(filesize($zipPath) / 1048576, 2) . ' MB' : $this->estimateSize($orderCount),
                    'created'    => $fileExists ? date('Y-m-d H:i:s', filemtime($zipPath)) : '-',
                    'downloaded' => '',
                    'orders'     => $orderCount,
                    'cached'     => $fileExists,
                ];

                $current->subMonth();
            }
        }

        return view('admin.backup.index', compact('files'));
    }

    /**
     * Download: get dữ liệu từ orders, nén thành zip và trả về
     */
    public function download(Request $request)
    {
        $filename = $request->query('file');

        // Extract year-month từ filename
        if (!preg_match('/(\d{4})-(\d{2})\.zip$/', $filename, $m)) {
            abort(400, 'Invalid file name');
        }

        $year  = $m[1];
        $month = $m[2];
        $domain = getDomain();

        // Kiểm tra file đã cache chưa
        $backupPath = $this->backupPath();
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $zipPath = $backupPath . '/' . $filename;

        // Nếu file chưa tồn tại → tạo mới từ database
        if (!file_exists($zipPath)) {
            $this->createBackupForMonth($domain, $year, $month, $zipPath);
        }

        if (!file_exists($zipPath)) {
            abort(500, 'Failed to create backup file');
        }

        return response()->download($zipPath, $filename, [
            'Content-Type' => 'application/zip',
        ]);
    }

    /**
     * Tạo file backup zip cho 1 tháng cụ thể
     */
    private function createBackupForMonth(string $domain, string $year, string $month, string $zipPath): void
    {
        $orders = Order::where('domain', $domain)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id')
            ->get();

        // Tạo CSV content
        $csvName = "{$year}-{$month}.csv";
        $csvContent = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csvContent .= "Order ID;Account;Service;Link;Quantity;Remains;Charge;Provider Charge;Status;Created;Changed\n";

        foreach ($orders as $order) {
            $csvContent .= implode(';', [
                $order->id,
                $order->user_id,
                $order->service_id,
                $order->link ?? '',
                $order->quantity ?? 0,
                $order->remains ?? 0,
                number_format($order->charge ?? 0, 10, '.', ''),
                number_format($order->total ?? 0, 10, '.', ''),
                number_format(0, 10, '.', ''),
                ucfirst($order->status ?? 'unknown'),
                $order->created_at?->format('Y-m-d H:i:s') ?? '',
                $order->updated_at?->format('Y-m-d H:i:s') ?? '',
            ]) . "\n";
        }

        // Tạo file zip
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFromString($csvName, $csvContent);
            $zip->close();
            Log::info("Backup: Created {$zipPath} with {$orders->count()} orders");
        } else {
            Log::error("Backup: Failed to create zip at {$zipPath}");
        }
    }

    /**
     * Ước tính dung lượng dựa trên số orders
     */
    private function estimateSize(int $orderCount): string
    {
        // Trung bình ~200 bytes/order khi nén
        $estimatedBytes = $orderCount * 200;
        return round($estimatedBytes / 1048576, 2) . ' MB';
    }
}
