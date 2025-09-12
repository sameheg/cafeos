<?php
namespace Modules\Pos\App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HardwareController extends Controller
{
    public function printReceipt(Request $request)
    {
        $data = $request->validate(['content'=>'required|string']);
        $driver = config('pos.hardware.driver', 'log');

        if ($driver === 'escpos' && class_exists('Mike42\\Escpos\\Printer')) {
            try {
                $connector = new \Mike42\Escpos\PrintConnectors\NetworkPrintConnector(parse_url(config('pos.hardware.printer_uri'), PHP_URL_HOST), (int)parse_url(config('pos.hardware.printer_uri'), PHP_URL_PORT));
                $printer = new \Mike42\Escpos\Printer($connector);
                $printer->text($data['content']."\n");
                $printer->cut();
                $printer->close();
                return response()->json(['message'=>'printed']);
            } catch (\Throwable $e) {
                return response()->json(['message'=>'printer_error','error'=>$e->getMessage()], 502);
            }
        }

        Log::info('[POS-HW] print simulated', ['content'=>substr($data['content'],0,120)]);
        return response()->json(['message'=>'printed_log']);
    }

    public function openDrawer()
    {
        $driver = config('pos.hardware.driver', 'log');
        if ($driver === 'escpos' && class_exists('Mike42\\Escpos\\Printer')) {
            try {
                $connector = new \Mike42\Escpos\PrintConnectors\NetworkPrintConnector(parse_url(config('pos.hardware.printer_uri'), PHP_URL_HOST), (int)parse_url(config('pos.hardware.printer_uri'), PHP_URL_PORT));
                $printer = new \Mike42\Escpos\Printer($connector);
                $printer->pulse();
                $printer->close();
                return response()->json(['message'=>'drawer_opened']);
            } catch (\Throwable $e) {
                return response()->json(['message'=>'printer_error','error'=>$e->getMessage()], 502);
            }
        }
        Log::info('[POS-HW] drawer open simulated');
        return response()->json(['message'=>'drawer_open_log']);
    }
}
