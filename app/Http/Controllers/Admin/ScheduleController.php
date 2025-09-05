<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ScheduledTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ScheduleController extends Controller
{
    public function index()
    {
        $tasks = ScheduledTask::all();
        return view('admin.schedule.index', compact('tasks'));
    }

    public function edit(ScheduledTask $task)
    {
        return view('admin.schedule.edit', compact('task'));
    }

    public function update(Request $request, ScheduledTask $task)
    {
        $data = $request->validate([
            'command' => 'required|string',
            'frequency' => 'required|string',
        ]);

        $task->update($data);

        return redirect()->route('admin.schedule.index');
    }

    public function toggle(ScheduledTask $task)
    {
        $task->enabled = ! $task->enabled;
        $task->save();

        return redirect()->route('admin.schedule.index');
    }

    public function run(ScheduledTask $task)
    {
        Artisan::call($task->command);

        return redirect()->route('admin.schedule.index')->with('status', Artisan::output());
    }
}
