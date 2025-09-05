<?php

namespace App\Services;

use App\System;
use App\User;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RegistrationService
{
    protected BusinessUtil $businessUtil;
    protected ModuleUtil $moduleUtil;

    public function __construct(
        BusinessUtil $businessUtil,
        ModuleUtil $moduleUtil
    ) {
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Gather data required for registration view
     *
     * @return array
     */
    public function getRegistrationData(): array
    {
        $currencies = $this->businessUtil->allCurrencies();
        $timezone_list = $this->businessUtil->allTimeZones();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = __('business.months.' . $i);
        }

        $accounting_methods = $this->businessUtil->allAccountingMethods();
        $package_id = request()->package;
        $system_settings = System::getProperties(['superadmin_enable_register_tc', 'superadmin_register_tc'], true);

        return compact(
            'currencies',
            'timezone_list',
            'months',
            'accounting_methods',
            'package_id',
            'system_settings'
        );
    }

    /**
     * Handle business registration
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerBusiness(Request $request)
    {
        try {
            $validator = $request->validate(
                [
                    'name' => 'required|max:255',
                    'currency_id' => 'required|numeric',
                    'country' => 'required|max:255',
                    'state' => 'required|max:255',
                    'city' => 'required|max:255',
                    'zip_code' => 'required|max:255',
                    'landmark' => 'required|max:255',
                    'time_zone' => 'required|max:255',
                    'surname' => 'max:10',
                    'email' => 'sometimes|nullable|email|unique:users|max:255',
                    'first_name' => 'required|max:255',
                    'username' => 'required|min:4|max:255|unique:users',
                    'password' => 'required|min:4|max:255',
                    'fy_start_month' => 'required',
                    'accounting_method' => 'required',
                ],
                [
                    'name.required' => __('validation.required', ['attribute' => __('business.business_name')]),
                    'name.currency_id' => __('validation.required', ['attribute' => __('business.currency')]),
                    'country.required' => __('validation.required', ['attribute' => __('business.country')]),
                    'state.required' => __('validation.required', ['attribute' => __('business.state')]),
                    'city.required' => __('validation.required', ['attribute' => __('business.city')]),
                    'zip_code.required' => __('validation.required', ['attribute' => __('business.zip_code')]),
                    'landmark.required' => __('validation.required', ['attribute' => __('business.landmark')]),
                    'time_zone.required' => __('validation.required', ['attribute' => __('business.time_zone')]),
                    'email.email' => __('validation.email', ['attribute' => __('business.email')]),
                    'email.email' => __('validation.unique', ['attribute' => __('business.email')]),
                    'first_name.required' => __('validation.required', ['attribute' => __('business.first_name')]),
                    'username.required' => __('validation.required', ['attribute' => __('business.username')]),
                    'username.min' => __('validation.min', ['attribute' => __('business.username')]),
                    'password.required' => __('validation.required', ['attribute' => __('business.username')]),
                    'password.min' => __('validation.min', ['attribute' => __('business.username')]),
                    'fy_start_month.required' => __('validation.required', ['attribute' => __('business.fy_start_month')]),
                    'accounting_method.required' => __('validation.required', ['attribute' => __('business.accounting_method')])
                ]
            );

            if (config('constants.enable_recaptcha')) {
                $recaptcha_validator = Validator::make($request->all(), [
                    'g-recaptcha-response' => ['required', new \App\Rules\ReCaptcha]
                ]);
                if ($recaptcha_validator->fails()) {
                    return back()->withErrors($recaptcha_validator)->withInput();
                }
            }

            DB::beginTransaction();

            //Create owner.
            $owner_details = $request->only(['surname', 'first_name', 'last_name', 'username', 'email', 'password', 'language']);
            $owner_details['language'] = empty($owner_details['language']) ? config('app.locale') : $owner_details['language'];
            $user = User::create_user($owner_details);

            $business_details = $request->only([
                'name', 'start_date', 'currency_id', 'time_zone',
                'fy_start_month', 'accounting_method', 'tax_label_1', 'tax_number_1',
                'tax_label_2', 'tax_number_2',
            ]);

            $business_location = $request->only([
                'name', 'country', 'state', 'city', 'zip_code', 'landmark',
                'website', 'mobile', 'alternate_number',
            ]);

            //Create the business
            $business_details['owner_id'] = $user->id;
            if (!empty($business_details['start_date'])) {
                $business_details['start_date'] = Carbon::createFromFormat(config('constants.default_date_format'), $business_details['start_date'])->toDateString();
            }

            $business = $this->businessUtil->createNewBusiness($business_details);

            //Update user with business id
            $user->business_id = $business->id;
            $user->save();

            $this->businessUtil->newBusinessDefaultResources($business->id, $user->id);
            $new_location = $this->businessUtil->addLocation($business->id, $business_location);

            //create new permission with the new location
            Permission::create(['name' => 'location.' . $new_location->id]);

            DB::commit();

            //Module function to be called after business is created
            if (config('app.env') != 'demo') {
                $this->moduleUtil->getModuleData('after_business_created', ['business' => $business]);
            }

            //Process payment information if superadmin is installed & package information is present
            $is_installed_superadmin = $this->moduleUtil->isSuperadminInstalled();
            $package_id = $request->get('package_id', null);
            if ($is_installed_superadmin && !empty($package_id) && (config('app.env') != 'demo')) {
                $package = \Modules\Superadmin\Entities\Package::find($package_id);
                if (!empty($package)) {
                    Auth::login($user);
                    return redirect()->route('register-pay', ['package_id' => $package_id]);
                }
            }

            $output = ['success' => 1,
                'msg' => __('business.business_created_succesfully'),
            ];

            return redirect('login')->with('status', $output);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());

            $output = ['success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];

            return back()->with('status', $output)->withInput();
        }
    }

    /**
     * Check if username already exists
     */
    public function checkUsername(string $username, ?string $username_ext = null): bool
    {
        if (!empty($username_ext)) {
            $username .= $username_ext;
        }
        $count = User::where('username', $username)->count();
        return $count == 0;
    }
}
