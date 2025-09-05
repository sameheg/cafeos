<?php

namespace Modules\Compliance\Services;

class EInvoiceService
{
    /**
     * Generate an electronic invoice payload for a specific country.
     *
     * Supported countries:
     *  - SA (Saudi Arabia - ZATCA)
     *  - AE (United Arab Emirates)
     *  - EG (Egypt)
     *
     * @param array $data    Raw invoice data
     * @param string $country ISO country code
     *
     * @throws \InvalidArgumentException When required fields are missing
     */
    public function generate(array $data, string $country): array
    {
        $invoice = [
            'number' => $data['number'] ?? uniqid('inv_'),
            'items'  => $data['items'] ?? [],
            'total'  => $data['total'] ?? 0,
        ];

        switch (strtoupper($country)) {
            case 'SA':
                $invoice['schema'] = 'ZATCA';
                $invoice['qr'] = $this->generateSaudiQr($data + $invoice);
                break;
            case 'AE':
                $invoice['schema'] = 'UAE';
                $invoice['qr'] = $this->encodeSimpleQr($data + $invoice, ['tax_registration_number']);
                break;
            case 'EG':
                $invoice['schema'] = 'EGYPT';
                $invoice['qr'] = $this->encodeSimpleQr($data + $invoice, ['registration_number']);
                break;
            default:
                throw new \InvalidArgumentException('Unsupported country code');
        }

        if (empty($invoice['qr'])) {
            throw new \InvalidArgumentException('QR content cannot be empty');
        }

        return $invoice;
    }

    /**
     * Generate ZATCA compliant QR (TLV base64 encoded).
     */
    private function generateSaudiQr(array $data): string
    {
        if (empty($data['seller_tax_number'])) {
            throw new \InvalidArgumentException('seller_tax_number is required for Saudi invoices');
        }

        $fields = [
            1 => $data['seller_name'] ?? '',
            2 => $data['seller_tax_number'],
            3 => $data['invoice_date'] ?? '',
            4 => (string) ($data['total'] ?? '0'),
            5 => (string) ($data['vat_total'] ?? '0'),
        ];

        $tlv = '';
        foreach ($fields as $tag => $value) {
            $tlv .= chr($tag) . chr(strlen($value)) . $value;
        }

        return base64_encode($tlv);
    }

    /**
     * Encode a simple JSON based QR for countries with lighter specs.
     *
     * @param array $requiredFields Fields that must exist in $data
     */
    private function encodeSimpleQr(array $data, array $requiredFields): string
    {
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \InvalidArgumentException("{$field} is required");
            }
        }

        return base64_encode(json_encode([
            'number' => $data['number'] ?? null,
            'tax' => $data['tax_registration_number'] ?? $data['registration_number'] ?? null,
        ]));
    }
}
