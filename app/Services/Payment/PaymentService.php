<?php

namespace App\Services\Payment;

interface PaymentService
{
    /**
     * Create an invoice or payment intent.
     *
     * @param array $data
     * @return mixed
     */
    public function createInvoice(array $data);

    /**
     * Capture a payment by its identifier.
     *
     * @param string $paymentId
     * @return mixed
     */
    public function capture(string $paymentId);

    /**
     * Refund a captured payment.
     *
     * @param string $paymentId
     * @param float $amount
     * @return mixed
     */
    public function refund(string $paymentId, float $amount);
}
