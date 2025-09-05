<?php

namespace App\Services\Payment;

class PayPalAdapter implements PaymentService
{
    public function createInvoice(array $data)
    {
        // TODO: Implement PayPal invoice creation.
        return [];
    }

    public function capture(string $paymentId)
    {
        // TODO: Implement PayPal capture.
        return [];
    }

    public function refund(string $paymentId, float $amount)
    {
        // TODO: Implement PayPal refund.
        return [];
    }
}
