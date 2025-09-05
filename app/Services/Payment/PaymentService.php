<?php

namespace App\Services\Payment;

interface PaymentService
{
    /**
     * Create an invoice or payment intent.
     *
     * @param array $data
     * @return array
     */
    public function createInvoice(array $data): array;

    /**
     * Capture a payment by its identifier.
     *
     * @param string $paymentId
     * @return array
     */
    public function capture(string $paymentId): array;

    /**
     * Refund a captured payment.
     *
     * @param string $paymentId
     * @param float $amount
     * @return array
     */
    public function refund(string $paymentId, float $amount): array;
}
