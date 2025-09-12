<?php

namespace Modules\Franchise\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TemplateUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(public string $templateId, public array $changes)
    {
    }

    public function broadcastAs(): string
    {
        return 'franchise.template.updated@v1';
    }

    public function payload(): array
    {
        return [
            'template_id' => $this->templateId,
            'changes' => $this->changes,
        ];
    }
}
