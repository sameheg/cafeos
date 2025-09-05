<?php

namespace App\Services;

use App\Notifications\TestEmailNotification;
use App\User;
use Illuminate\Support\Facades\Notification;

class MailService
{
    protected array $mailDrivers = [
        'smtp' => 'SMTP',
    ];

    public function getMailDrivers(): array
    {
        return $this->mailDrivers;
    }

    public function checkEmail(string $email, ?int $userId = null): bool
    {
        $query = User::where('email', $email);
        if (!empty($userId)) {
            $query->where('id', '!=', $userId);
        }
        return $query->exists();
    }

    public function testEmailConfiguration(array $email_settings): array
    {
        try {
            $data['email_settings'] = $email_settings;
            Notification::route('mail', $email_settings['mail_from_address'])
                ->notify(new TestEmailNotification($data));
            return [
                'success' => 1,
                'msg' => __('lang_v1.email_tested_successfully'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
            return [
                'success' => 0,
                'msg' => $e->getMessage(),
            ];
        }
    }
}
