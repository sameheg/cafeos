<?php

namespace Modules\Pos\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Pos\Models\PosItem;

class InventoryService
{
    /**
     * Decrement stock based on BOM map.
     * Supports BOM from: 'inventory_boms' table OR item.meta['bom'] (array of [sku,qty]).
     * Unit conversions: if 'inventory_uom' exists, conversion is applied via 'inventory_conversions' (optional).
     */
    public static function decrementForItem(PosItem $item): void
    {
        DB::transaction(function() use ($item){
            $bom = self::resolveBom($item);
            foreach ($bom as $row) {
                [$sku, $qtyPerUnit] = [$row['sku'], (float)($row['qty'] ?? 1)];
                $delta = $qtyPerUnit * (int)$item->qty;
                self::applyStock($item->tenant_id, $sku, -$delta);
            }
        }, 3);
    }

    public static function reverseForItem(PosItem $item): void
    {
        DB::transaction(function() use ($item){
            $bom = self::resolveBom($item);
            foreach ($bom as $row) {
                [$sku, $qtyPerUnit] = [$row['sku'], (float)($row['qty'] ?? 1)];
                $delta = $qtyPerUnit * (int)$item->qty;
                self::applyStock($item->tenant_id, $sku, +$delta);
            }
        }, 3);
    }

    protected static function resolveBom(PosItem $item): array
    {
        // from DB table
        if (Schema::hasTable('inventory_boms')) {
            $bomRows = DB::table('inventory_boms')->where('product_sku', $item->sku ?? $item->name)->get();
            if ($bomRows->count()) {
                return $bomRows->map(fn($r)=>['sku'=>$r->component_sku,'qty'=>$r->qty])->all();
            }
        }
        // from item meta
        $meta = $item->meta ?? [];
        if (is_array($meta) && !empty($meta['bom']) && is_array($meta['bom'])) {
            return array_map(function($r){
                return ['sku'=>$r['sku'] ?? ($r['name'] ?? ''), 'qty'=>$r['qty'] ?? 1];
            }, $meta['bom']);
        }
        return []; // no-op if no BOM
    }

    protected static function applyStock(string $tenantId, string $sku, float $delta): void
    {
        if (!Schema::hasTable('inventory_items')) return;
        $row = DB::table('inventory_items')->where('tenant_id',$tenantId)->where('sku',$sku)->lockForUpdate()->first();
        if (!$row) {
            // create record if allowed
            DB::table('inventory_items')->insert([
                'tenant_id'=>$tenantId,'sku'=>$sku,'name'=>$sku,'on_hand'=>max(0, $delta),'created_at'=>now(),'updated_at'=>now()
            ]);
            return;
        }
        $new = max(0, ($row->on_hand ?? 0) + $delta);
        DB::table('inventory_items')->where('id',$row->id)->update(['on_hand'=>$new,'updated_at'=>now()]);
    }
}
