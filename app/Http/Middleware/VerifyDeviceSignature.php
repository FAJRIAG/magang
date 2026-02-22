<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Device;

class VerifyDeviceSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deviceId = $request->input('device_id');
        $signature = $request->input('signature');
        $rfid = $request->input('rfid_uid');

        if (!$deviceId || !$signature || !$rfid) {
            return response()->json(['status' => 'DENY', 'reason' => 'Missing parameters'], 400);
        }

        $device = Device::where('device_id', $deviceId)->first();

        if (!$device) {
            return response()->json(['status' => 'DENY', 'reason' => 'Invalid device'], 401);
        }

        // Compute Expected Signature
        // Assuming the signature is HMAC SHA256 of rfid_uid using the device secret key.
        // It could also be rfid_uid . device_id. Let's use rfid_uid for now as it's the main data.
        $expectedSignature = hash_hmac('sha256', $rfid, $device->secret_key);

        if (!hash_equals($expectedSignature, $signature)) {
            return response()->json(['status' => 'DENY', 'reason' => 'Invalid signature'], 403);
        }

        return $next($request);
    }
}
