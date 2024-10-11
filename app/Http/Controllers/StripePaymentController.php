<?php

namespace App\Http\Controllers;

use Stripe\StripeClient;
use Illuminate\Http\Request;
class StripePaymentController extends Controller
{
    public $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(
            config('services.stripe.secret')
        );
    }

    public function pay(Request $request)
    {
        $items = $request->query('items');
        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] =[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100,
                ],
                'quantity' => $item['quantity'],
            ];
        }
        $session = $this->stripe->checkout->sessions->create([
            'mode'=> 'payment',
            'success_url'=> 'https://example.com/success',
            'line_items' => $lineItems
        ]);
        return redirect()->to($session->url);
    }
}
