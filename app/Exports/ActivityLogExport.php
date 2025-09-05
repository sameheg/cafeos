<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLogExport implements FromCollection, WithHeadings
{
    protected Collection $activities;

    public function __construct(Collection $activities)
    {
        $this->activities = $activities;
    }

    public function collection(): Collection
    {
        return $this->activities->map(function ($row) {
            return [
                $row->created_at,
                $row->created_by,
                $row->subject_type,
                __('lang_v1.' . $row->description),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Date',
            'Created By',
            'Subject',
            'Description',
        ];
    }
}

