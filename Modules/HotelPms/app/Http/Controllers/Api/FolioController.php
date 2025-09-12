<?php

namespace Modules\HotelPms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\HotelPms\Events\FolioPosted;
use Modules\HotelPms\Models\Folio;

class FolioController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'guest_id' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $folio = Folio::create([
            'tenant_id' => $request->header('X-Tenant', (string) Str::uuid()),
            'guest_id' => $data['guest_id'],
            'total' => $data['amount'],
            'status' => Folio::STATUS_POSTED,
        ]);
        FolioPosted::dispatch($folio);

        return response()->json(['posted' => $folio->status === Folio::STATUS_POSTED]);
    }
}
