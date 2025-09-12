<?php

namespace Modules\Franchise\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Pennant\Feature;
use Modules\Franchise\Enums\TemplateState;
use Modules\Franchise\Models\FranchiseTemplate;

class TemplateController extends BaseController
{
    public function update(Request $request, FranchiseTemplate $template): JsonResponse
    {
        $validated = $request->validate([
            'changes' => 'required|array',
        ]);

        if ($template->state === TemplateState::Overridden) {
            return response()->json(['error' => 'conflict'], 409);
        }

        if (Feature::active('franchise_margin_guards') && ($validated['changes']['price'] ?? 0) < 0) {
            return response()->json(['error' => 'margin'], 409);
        }

        $template->syncPush($validated['changes']);

        return response()->json(['success' => true]);
    }
}
