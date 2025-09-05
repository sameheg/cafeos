<?php

namespace App\Services\Accounting;

interface AccountingInterface
{
    /**
     * Sync an invoice with the accounting provider.
     *
     * @param array $invoice
     * @return bool
     */
    public function syncInvoice(array $invoice): bool;

    /**
     * Map tax data to the provider specific format.
     *
     * @param array $tax
     * @return array
     */
    public function mapTax(array $tax): array;

    /**
     * Authenticate with the accounting provider.
     *
     * @param array $credentials
     * @return bool
     */
    public function authenticate(array $credentials): bool;
}
