<?php

namespace Modules\CRM\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Aloha\Twilio\Facades\Twilio;

class SendCampaignMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $channel;
    protected string $recipient;
    protected string $content;

    public function __construct(string $channel, string $recipient, string $content)
    {
        $this->channel = $channel;
        $this->recipient = $recipient;
        $this->content = $content;
    }

    public function handle(): void
    {
        if ($this->channel === 'sms') {
            Twilio::message($this->recipient, $this->content);
        } else {
            Mail::raw($this->content, function ($message) {
                $message->to($this->recipient)->subject('Marketing Campaign');
            });
        }
    }
}
