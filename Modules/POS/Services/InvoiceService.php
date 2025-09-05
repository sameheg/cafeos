<?php

namespace Modules\POS\Services;

use Modules\Compliance\Services\EInvoiceService;
use Milon\Barcode\DNS2D;

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
        $data = $this->qrPayload($invoice);

        $dns = new DNS2D();
        $dns->setStorPath(sys_get_temp_dir());
        $base64 = $dns->getBarcodePNG($data, 'QRCODE');

        return 'data:image/png;base64,' . $base64;
    }

    protected function qrPayload(array $invoice): string
    {
        return json_encode([
            'number' => $invoice['number'] ?? null,
            'total' => $invoice['total'] ?? null,
        ]);
    }
}
