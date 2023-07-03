<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Session;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class Midtrans extends Controller
{
    public $snapUrl = "";
    public $apiUrl = "";
    protected $secretKey;
    public function __construct()
    {
        $this->secretKey = env("MIDTRANS_SECRET");
        $this->snapUrl = env("MIDTRANS_PROD") ? "https://app.midtrans.com" : "https://app.sandbox.midtrans.com";
        $this->apiUrl = env("MIDTRANS_PROD") ? "https://api.midtrans.com" : "https://api.sandbox.midtrans.com";
    }
    public function checkTransaction($id)
    {
        $client = new Client();
        $response = $client->request('GET', $this->apiUrl . "/v2/$id/status", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->secretKey . ":"),
            ]
        ]);
        $body = $response->getBody();
        $data = json_decode($body);
        return $data;
    }
    public function payment($amount)
    {
        $client = new Client();
        $response = $client->request('POST', $this->snapUrl . "/snap/v1/transactions", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->secretKey . ":"),
            ],
            'json' => [
                'transaction_details' => [
                    'order_id' => time(),
                    'gross_amount' => $amount,
                ]
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);
        $uuid = $data['token'];

        $response = $client->request('POST', $this->snapUrl . "/snap/v2/transactions/$uuid/charge", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->secretKey . ":"),
            ],
            'json' => [
                'payment_type' => 'other_qris'
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data;
    }
//
}