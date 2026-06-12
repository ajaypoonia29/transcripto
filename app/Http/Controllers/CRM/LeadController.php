<?php

declare(strict_types=1);

namespace App\Http\Controllers\CRM;

use App\Domains\CRM\Actions\IngestLeadAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeadController extends Controller
{
    public function __construct(
        protected readonly IngestLeadAction $ingestLeadAction
    ) {}

    /**
     * Store a newly created lead.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'pipeline_status' => ['required', 'string', 'max:50'],
            'preferred_program_type' => ['required', 'string', 'max:100'],
        ]);

        /** @var array{full_name: string, email_address: string, phone_number: string, pipeline_status: string, preferred_program_type: string} $validated */
        $lead = $this->ingestLeadAction->execute($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lead successfully ingested.',
            'data' => [
                'id' => $lead->id,
                'full_name' => $lead->full_name,
                'email_address' => $lead->email_address,
                'pipeline_status' => $lead->pipeline_status,
            ],
        ], Response::HTTP_CREATED);
    }
}
