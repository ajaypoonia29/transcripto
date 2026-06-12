<?php

declare(strict_types=1);

namespace App\Http\Controllers\Coaching;

use App\Domains\Coaching\Actions\AssignPlansAction;
use App\Domains\Coaching\Actions\FetchMemberDashboardAction;
use App\Domains\Coaching\Actions\ToggleCompletionAction;
use App\Domains\Payments\Models\PaymentRecord;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoachingController extends Controller
{
    public function __construct(
        protected readonly AssignPlansAction $assignPlansAction,
        protected readonly FetchMemberDashboardAction $fetchMemberDashboardAction,
        protected readonly ToggleCompletionAction $toggleCompletionAction
    ) {}

    /**
     * Fetch all members (users) for the coach selection dropdown.
     */
    public function members(): JsonResponse
    {
        // Gather unique user_ids from payments
        $userIds = PaymentRecord::query()->select('user_id')->distinct()->pluck('user_id')->toArray();
        
        // Ensure we always have at least user 1 and user 2 for demo purposes
        if (!in_array(1, $userIds)) {
            $userIds[] = 1;
        }
        if (!in_array(2, $userIds)) {
            $userIds[] = 2;
        }

        $names = [
            1 => 'John Doe (Premium Member)',
            2 => 'Jane Smith (Elite Member)',
            3 => 'Alex Johnson (Basic Member)',
            4 => 'Michael Brown (Consultation Client)',
        ];

        $members = [];
        foreach ($userIds as $id) {
            $idInt = (int) $id;
            $members[] = [
                'user_id' => $idInt,
                'name' => $names[$idInt] ?? "Member #{$idInt}",
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $members,
        ], Response::HTTP_OK);
    }

    /**
     * Display the member dashboard plans and progress logs.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'integer'],
        ]);

        $userId = (int) ($validated['user_id'] ?? 1);

        $data = $this->fetchMemberDashboardAction->execute($userId);

        return response()->json([
            'success' => true,
            'data' => [
                'user_id' => $userId,
                'workouts' => $data['workouts'],
                'diets' => $data['diets'],
                'progress_logs' => $data['progress_logs'],
            ],
        ], Response::HTTP_OK);
    }

    /**
     * Check-in / Toggle completion of a plan item.
     */
    public function checkIn(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer'],
            'type' => ['required', 'string', 'in:workout,diet'],
            'item_id' => ['required', 'integer'],
            'is_completed' => ['required', 'boolean'],
        ]);

        $this->toggleCompletionAction->execute(
            (int) $validated['user_id'],
            (string) $validated['type'],
            (int) $validated['item_id'],
            (bool) $validated['is_completed']
        );

        return response()->json([
            'success' => true,
            'message' => 'Check-in successfully recorded.',
        ], Response::HTTP_OK);
    }

    /**
     * Assign / Overwrite weekly workouts and diets.
     */
    public function assign(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer'],
            'workouts' => ['required', 'array'],
            'workouts.*.day_of_week' => ['required', 'string'],
            'workouts.*.exercise_name' => ['required', 'string'],
            'workouts.*.sets' => ['required', 'integer', 'min:1'],
            'workouts.*.reps' => ['required', 'string'],
            'diets' => ['required', 'array'],
            'diets.*.meal_name' => ['required', 'string'],
            'diets.*.food_items' => ['required', 'string'],
            'diets.*.calories' => ['required', 'integer', 'min:0'],
        ]);

        $this->assignPlansAction->execute(
            (int) $validated['user_id'],
            (array) $validated['workouts'],
            (array) $validated['diets']
        );

        return response()->json([
            'success' => true,
            'message' => 'Weekly workout and diet plans successfully assigned.',
        ], Response::HTTP_OK);
    }

    /**
     * Authenticate coach and member credentials.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $email = strtolower($validated['email']);
        $password = $validated['password'];

        if ($email === 'admin@transcripto.in' && $password === 'admin123') {
            return response()->json([
                'success' => true,
                'role' => 'admin',
                'user_id' => 999,
                'name' => 'Coach Administrator',
            ], Response::HTTP_OK);
        }

        if ($email === 'john@transcripto.in' && $password === 'client123') {
            return response()->json([
                'success' => true,
                'role' => 'client',
                'user_id' => 1,
                'name' => 'John Doe',
            ], Response::HTTP_OK);
        }

        if ($email === 'jane@transcripto.in' && $password === 'client123') {
            return response()->json([
                'success' => true,
                'role' => 'client',
                'user_id' => 2,
                'name' => 'Jane Smith',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password. Use admin@transcripto.in/admin123 or john@transcripto.in/client123.',
        ], Response::HTTP_UNAUTHORIZED);
    }
}

