<?php
namespace Modules\Pos\App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Pos\App\Services\PosAudit;

class OfflineSyncController extends Controller
{
    public function __construct(private PosAudit $audit) {}

    public function sync(Request $request)
    {
        // RBAC: allow only specific roles
        $roles = config('pos.offline_sync.allow_roles', []);
        if (!auth()->check() || !auth()->user()->hasRole($roles)) {
            return response()->json(['message'=>'Forbidden'], 403);
        }

        $payload = $request->validate([
            'mutations' => 'required|array',
            'client_id' => 'required|string',
            'seq' => 'required|integer',
        ]);

        $results = [];
        DB::transaction(function () use ($payload, &$results) {
            foreach ($payload['mutations'] as $i => $mutation) {
                // Simplified conflict detection skeleton
                $hash = $mutation['hash'] ?? null;
                $serverHash = $hash; // replace with actual record hash
                if ($hash && $serverHash && $hash !== $serverHash) {
                    $results[] = ['index'=>$i,'status'=>'conflict'];
                    continue;
                }
                // Apply mutation (pseudo)
                $results[] = ['index'=>$i,'status'=>'applied'];
            }
        });

        $this->audit->log('offline.sync', ['client_id'=>$payload['client_id'],'seq'=>$payload['seq']]);
        return response()->json(['ack'=>true,'results'=>$results]);
    }
}
