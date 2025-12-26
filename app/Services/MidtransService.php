<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction($transaksi)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_invoice,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->user->name,
                'email' => $transaksi->user->email,
                'phone' => $transaksi->user->phone,
            ],
            'item_details' => [],
            'enabled_payments' => ['qris'],
        ];

        // Add item details
        foreach ($transaksi->detailTransaksis as $detail) {
            $params['item_details'][] = [
                'id' => $detail->paket->id,
                'price' => (int) $detail->harga_satuan,
                'quantity' => (int) $detail->jumlah,
                'name' => $detail->paket->nama_paket,
            ];
        }

        // Add discount if exists
        if ($transaksi->diskon > 0) {
            $params['item_details'][] = [
                'id' => 'discount',
                'price' => -(int) $transaksi->diskon,
                'quantity' => 1,
                'name' => 'Diskon Promo',
            ];
        }

        try {
            $snapToken = Snap::getSnapToken($params);
            return [
                'success' => true,
                'snap_token' => $snapToken,
                'redirect_url' => "https://app.sandbox.midtrans.com/snap/v2/vtweb/{$snapToken}"
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getTransactionStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            return [
                'success' => true,
                'status' => $status
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function handleNotification($notification)
    {
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;

        if ($transactionStatus == 'settlement') {
            return 'paid';
        } elseif ($transactionStatus == 'pending') {
            return 'pending';
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            return 'failed';
        }

        return 'unknown';
    }
}