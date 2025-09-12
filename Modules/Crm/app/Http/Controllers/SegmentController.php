<?php

declare(strict_types=1);

namespace Modules\Crm\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Crm\Models\Segment;

class SegmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'segments' => Segment::select('id', 'name', 'criteria')->get(),
        ]);
    }
}
