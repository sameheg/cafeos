<?php

namespace App\Http\Controllers;

use App\Services\IntegrationSettingsService;
use Illuminate\Http\Request;

class SystemIntegrationController extends Controller
{
    public function __construct(protected IntegrationSettingsService $settings)
    {
    }

    public function index()
    {
        $defaults = [
            'myfatoorah' => [
                'api_key' => '',
                'test_mode' => '',
                'country_iso' => '',
            ],
            'sms' => [
                'twilio_sid' => '',
                'twilio_token' => '',
                'twilio_from' => '',
            ],
            'mail' => [
                'mail_driver' => '',
                'mail_host' => '',
                'mail_port' => '',
                'mail_username' => '',
                'mail_password' => '',
                'mail_encryption' => '',
                'mail_from_address' => '',
                'mail_from_name' => '',
            ],
        ];
        $existing = $this->settings->all();
        $settings = array_replace_recursive($defaults, $existing);

        return view('system.integrations', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->input('settings', []);
        foreach ($data as $service => $pairs) {
            foreach ($pairs as $key => $value) {
                $this->settings->set($service, $key, $value);
            }
        }

        return redirect()->back()->with('status', __('lang_v1.updated_success'));
    }
}
