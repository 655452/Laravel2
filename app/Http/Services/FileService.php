<?php

namespace App\Http\Services;

use App\Http\Services\ResponseService;
use App\Models\Order;

class FileService
{
    public function orderFile($orderId, $request)
    {
        $order = Order::findOrfail($orderId);
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $image_name = time() . '.' . $request->file('attachment')->extension();
            $order->media()->delete();
            $order->addMediaFromRequest('attachment')->usingFileName($image_name)->toMediaCollection('orders');
            ResponseService::set(['status' => true]);
        } else {
            ResponseService::set(['message' => 'something wrong']);
        }

        return ResponseService::response();
    }

    public function orderFileApi($orderId, $request)
    {
        $order = Order::find($orderId);
        if (blank($order)) {
            ResponseService::set(['message' => 'something wrong']);
        }

        if ($request->get('image') != '') {
            $realImage = base64_decode($request->get('image'));
            file_put_contents($request->get('fileName'), $realImage);

            $url = public_path($request->get('fileName'));

            $order->media()->delete();
            $order->addMediaFromUrl($url)->toMediaCollection('orders');

            File::delete($url);

            ResponseService::set(['status' => true]);
        }
        return ResponseService::response();
    }
}
