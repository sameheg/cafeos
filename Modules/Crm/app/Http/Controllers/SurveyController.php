<?php

namespace Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Crm\Contracts\SurveyServiceInterface;

class SurveyController extends Controller
{
    public function __construct(private SurveyServiceInterface $surveys) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'branch_id' => 'required|integer',
            'question' => 'required|string',
        ]);

        $survey = $this->surveys->createSurvey(tenant('id'), $data['branch_id'], $data['question']);

        return response()->json($survey);
    }

    public function respond(Request $request, int $survey)
    {
        $data = $request->validate([
            'branch_id' => 'required|integer',
            'rating' => 'required|integer',
            'comment' => 'nullable|string',
        ]);

        $response = $this->surveys->submitResponse($survey, $data['branch_id'], $data['rating'], $data['comment'] ?? null);

        return response()->json($response);
    }
}
