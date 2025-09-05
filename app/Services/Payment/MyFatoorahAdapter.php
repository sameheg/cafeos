<?php

namespace App\Services\Payment;

use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;

class MyFatoorahAdapter implements PaymentService
{
    /**
     * MyFatoorah configuration options.
     */
    protected array $config;

    public function __construct()
    {
        $this->config = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function createInvoice(array $data)
    {
        $mf = new MyFatoorahPayment($this->config);
        $paymentMethod = $data['paymentMethodId'] ?? 0;
        $packageId     = $data['CustomerReference'] ?? null;
        $sessionId     = $data['SessionId'] ?? null;

        return $mf->getInvoiceURL($data, $paymentMethod, $packageId, $sessionId);
    }

    /**
     * {@inheritDoc}
     */
    public function capture(string $paymentId)
    {
        $mf = new MyFatoorahPaymentStatus($this->config);
        return $mf->getPaymentStatus($paymentId, 'PaymentId');
    }

    /**
     * {@inheritDoc}
     */
    public function refund(string $paymentId, float $amount)
    {
        // MyFatoorah refunds are handled via the API.
        // Implementation can be extended when required.
        return [
            'paymentId' => $paymentId,
            'amount' => $amount,
            'status' => 'pending',
        ];
    }
}
