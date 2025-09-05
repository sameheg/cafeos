<?php

namespace App\Http\Controllers;

use App\DashboardConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardConfiguratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        $dashboards = DashboardConfiguration::where('business_id', $business_id)->get();

        return view('dashboard_configurator.index', compact('dashboards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        return view('dashboard_configurator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
            'color' => 'required',
        ]);

        try {
            $business_id = $request->session()->get('user.business_id');

            $dashboard = new DashboardConfiguration();
            $dashboard->business_id = $business_id;
            $dashboard->created_by = $request->user()->id;
            $dashboard->name = $request->input('name');
            $dashboard->color = $request->input('color');
            $dashboard->configuration = $request->input('configuration', '[]');
            $dashboard->save();

            $output = ['success' => true,
                'msg' => __('lang_v1.success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->action([self::class, 'index'])->with('status', $output);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $dashboard = DashboardConfiguration::where('business_id', $business_id)->findOrFail($id);
        $dashboard->configuration = json_decode($dashboard->configuration, true);

        return view('dashboard_configurator.show', compact('dashboard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business_id = request()->session()->get('user.business_id');

        //get the configuration.
        $dashboard = DashboardConfiguration::where('business_id', $business_id)->findorfail($id);
        $dashboard->configuration = json_decode($dashboard->configuration, true);

        //Get all widgets
        $available_widgets = [];
        if (Schema::hasTable('dashboard_widgets')) {
            $available_widgets = DB::table('dashboard_widgets')
                                    ->get()
                                    ->mapWithKeys(function ($widget) {
                                        return [$widget->name => ['title' => $widget->title]];
                                    })
                                    ->toArray();
        }

        return view('dashboard_configurator.edit', compact('dashboard', 'available_widgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['configuration']);
            $business_id = $request->session()->get('user.business_id');

            $dashboard = DashboardConfiguration::where('business_id', $business_id)->findOrFail($id);
            $dashboard->configuration = $input['configuration'];
            $dashboard->save();

            $output = ['success' => true,
                'msg' => __('lang_v1.success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return back()->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user()->can('configure_dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $dashboard = DashboardConfiguration::where('business_id', $business_id)->findOrFail($id);
            $dashboard->delete();

            $output = ['success' => true,
                'msg' => __('lang_v1.success'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return back()->with('status', $output);
    }
}
