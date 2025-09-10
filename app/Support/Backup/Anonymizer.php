<?php

namespace App\Support\Backup;

use Illuminate\Support\Str;

class Anonymizer
{
    /**
     * Fields considered sensitive and should be anonymized in backups.
     *
     * @var array<int, string>
     */
    protected array $fields = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Anonymize sensitive fields for a single record.
     *
     * @param array<string, mixed> $record
     * @return array<string, mixed>
     */
    public function anonymize(array $record): array
    {
        foreach ($this->fields as $field) {
            if (! isset($record[$field])) {
                continue;
            }

            if ($field === 'email') {
                $record[$field] = Str::random(10).'@example.com';
                continue;
            }

            $record[$field] = Str::random(10);
        }

        return $record;
    }
}
