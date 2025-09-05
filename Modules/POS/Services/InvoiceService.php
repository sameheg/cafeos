<?php

namespace Modules\POS\Services;

use Modules\Compliance\Services\EInvoiceService;

class InvoiceService
{
    protected EInvoiceService $eInvoiceService;

    public function __construct(EInvoiceService $eInvoiceService)
    {
        $this->eInvoiceService = $eInvoiceService;
    }

    /**
     * Issue an invoice with QR code and e-invoice payload.
     *
     * @param array $data
     * @return array
     */
    public function issue(array $data): array
    {
        $invoice = $this->eInvoiceService->generate($data);
        $invoice['qr_code'] = $this->generateQrCode($invoice);

        return $invoice;
    }

    protected function generateQrCode(array $invoice): string
    {
        // Placeholder QR generation; replace with actual library
        return base64_encode(json_encode([
            'number' => $invoice['number'] ?? null,
            'total' => $invoice['total'] ?? null,
        ]));
    }
}
