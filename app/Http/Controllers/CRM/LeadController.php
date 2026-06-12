<?php

declare(strict_types=1);

namespace App\Http\Controllers\CRM;

use App\Domains\CRM\Actions\IngestLeadAction;
use App\Domains\CRM\Actions\FetchLeadsAction;
use App\Domains\CRM\Actions\UpdateLeadAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeadController extends Controller
{
    public function __construct(
        protected readonly IngestLeadAction $ingestLeadAction,
        protected readonly FetchLeadsAction $fetchLeadsAction,
        protected readonly UpdateLeadAction $updateLeadAction
    ) {}

    /**
     * Display a listing of the leads.
     */
    public function index(): JsonResponse
    {
        $leads = $this->fetchLeadsAction->execute();

        return response()->json([
            'success' => true,
            'data' => $leads,
        ], Response::HTTP_OK);
    }

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

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => ['string', 'max:255'],
            'email_address' => ['email', 'max:255'],
            'phone_number' => ['string', 'max:20'],
            'pipeline_status' => ['string', 'max:50'],
            'preferred_program_type' => ['string', 'max:100'],
        ]);

        $lead = $this->updateLeadAction->execute($id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Lead successfully updated.',
            'data' => $lead,
        ], Response::HTTP_OK);
    }
}
