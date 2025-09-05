<?php

namespace App\Services\Payment;

class StripeAdapter implements PaymentService
{
    public function createInvoice(array $data)
    {
        // TODO: Implement Stripe invoice creation.
        return [];
    }

    public function capture(string $paymentId)
    {
        // TODO: Implement Stripe capture.
        return [];
    }

    public function refund(string $paymentId, float $amount)
    {
        // TODO: Implement Stripe refund.
        return [];
    }
}
