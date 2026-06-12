<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Seed CRM Leads
        DB::table('crm_leads')->insert([
            [
                'id' => 1,
                'full_name' => 'John Doe',
                'email_address' => 'john@transcripto.in',
                'phone_number' => '+91 98765 43210',
                'pipeline_status' => 'joined',
                'preferred_program_type' => 'Muscle Gain',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'email_address' => 'jane@transcripto.in',
                'phone_number' => '+91 87654 32109',
                'pipeline_status' => 'joined',
                'preferred_program_type' => 'Weight Loss',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'id' => 3,
                'full_name' => 'Alex Johnson',
                'email_address' => 'alex@transcripto.in',
                'phone_number' => '+91 76543 21098',
                'pipeline_status' => 'new',
                'preferred_program_type' => 'PCOS Program',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id' => 4,
                'full_name' => 'Michael Brown',
                'email_address' => 'michael@transcripto.in',
                'phone_number' => '+91 65432 10987',
                'pipeline_status' => 'contacted',
                'preferred_program_type' => 'Muscle Gain',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ]);

        // 2. Seed Payment Records
        DB::table('payment_records')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'pricing_plan_id' => 'premium_monthly',
                'razorpay_order_id' => 'order_m_john_001',
                'razorpay_payment_id' => 'pay_john_001',
                'amount_paid' => 299900, // INR 2,999 in paise
                'transaction_status' => 'completed',
                'scheduled_at' => null,
                'google_meet_link' => null,
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'pricing_plan_id' => 'elite_annual',
                'razorpay_order_id' => 'order_m_jane_002',
                'razorpay_payment_id' => 'pay_jane_002',
                'amount_paid' => 1999900, // INR 19,999 in paise
                'transaction_status' => 'completed',
                'scheduled_at' => null,
                'google_meet_link' => null,
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'pricing_plan_id' => 'basic_monthly',
                'razorpay_order_id' => 'order_m_alex_003',
                'razorpay_payment_id' => null,
                'amount_paid' => 99900,
                'transaction_status' => 'initiated',
                'scheduled_at' => null,
                'google_meet_link' => null,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'pricing_plan_id' => 'paid_consultation',
                'razorpay_order_id' => 'order_meet_004',
                'razorpay_payment_id' => 'pay_meet_004',
                'amount_paid' => 49900, // INR 499
                'transaction_status' => 'completed',
                'scheduled_at' => Carbon::now()->addDays(2)->setTime(15, 0, 0),
                'google_meet_link' => 'https://meet.google.com/abc-defg-hij',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ]);

        // 3. Seed Workout Plans
        DB::table('workout_plans')->insert([
            // John Doe (user_id 1)
            [
                'user_id' => 1,
                'day_of_week' => 'Monday',
                'exercise_name' => 'Barbell Squats',
                'sets' => 4,
                'reps' => '10-12',
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'day_of_week' => 'Monday',
                'exercise_name' => 'Leg Press',
                'sets' => 3,
                'reps' => '12-15',
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'day_of_week' => 'Wednesday',
                'exercise_name' => 'Bench Press',
                'sets' => 4,
                'reps' => '8-10',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'day_of_week' => 'Wednesday',
                'exercise_name' => 'Incline Dumbbell Press',
                'sets' => 3,
                'reps' => '10-12',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'day_of_week' => 'Friday',
                'exercise_name' => 'Deadlifts',
                'sets' => 4,
                'reps' => '5',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'day_of_week' => 'Friday',
                'exercise_name' => 'Pullups',
                'sets' => 4,
                'reps' => 'Max reps',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Jane Smith (user_id 2)
            [
                'user_id' => 2,
                'day_of_week' => 'Tuesday',
                'exercise_name' => 'Dumbbell Lunges',
                'sets' => 3,
                'reps' => '12 per leg',
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'day_of_week' => 'Tuesday',
                'exercise_name' => 'Dumbbell Shoulder Press',
                'sets' => 3,
                'reps' => '12',
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'day_of_week' => 'Thursday',
                'exercise_name' => 'Lat Pulldowns',
                'sets' => 3,
                'reps' => '12',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'day_of_week' => 'Thursday',
                'exercise_name' => 'Cable Rows',
                'sets' => 3,
                'reps' => '12',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'day_of_week' => 'Saturday',
                'exercise_name' => 'Plank Hold',
                'sets' => 3,
                'reps' => '60 seconds',
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 4. Seed Diet Plans
        DB::table('diet_plans')->insert([
            // John Doe (user_id 1)
            [
                'user_id' => 1,
                'meal_name' => 'Breakfast',
                'food_items' => 'Oatmeal with whey protein, chia seeds & banana',
                'calories' => 450,
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'meal_name' => 'Lunch',
                'food_items' => 'Grilled chicken breast, brown rice & steamed broccoli',
                'calories' => 650,
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'meal_name' => 'Snack',
                'food_items' => 'Almonds and greek yogurt',
                'calories' => 250,
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'meal_name' => 'Dinner',
                'food_items' => 'Baked salmon, sweet potato & mixed green salad',
                'calories' => 550,
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Jane Smith (user_id 2)
            [
                'user_id' => 2,
                'meal_name' => 'Breakfast',
                'food_items' => 'Egg white omelette with spinach & 1 slice whole wheat toast',
                'calories' => 300,
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'meal_name' => 'Lunch',
                'food_items' => 'Quinoa salad with chickpeas, cucumber & feta cheese',
                'calories' => 450,
                'is_completed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'meal_name' => 'Snack',
                'food_items' => 'Apple slices with 1 tbsp peanut butter',
                'calories' => 200,
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'meal_name' => 'Dinner',
                'food_items' => 'Grilled tofu, stir-fry vegetables & brown rice',
                'calories' => 400,
                'is_completed' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // 5. Seed Progress Logs
        DB::table('progress_logs')->insert([
            // John Doe (user_id 1)
            [
                'user_id' => 1,
                'log_date' => Carbon::today()->subDays(4)->toDateString(),
                'weight' => 82.5,
                'workout_completed_pct' => 50,
                'diet_completed_pct' => 75,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => 1,
                'log_date' => Carbon::today()->subDays(3)->toDateString(),
                'weight' => 82.3,
                'workout_completed_pct' => 100,
                'diet_completed_pct' => 100,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 1,
                'log_date' => Carbon::today()->subDays(2)->toDateString(),
                'weight' => 82.2,
                'workout_completed_pct' => 50,
                'diet_completed_pct' => 50,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => 1,
                'log_date' => Carbon::today()->subDays(1)->toDateString(),
                'weight' => 82.0,
                'workout_completed_pct' => 100,
                'diet_completed_pct' => 75,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 1,
                'log_date' => Carbon::today()->toDateString(),
                'weight' => 81.9,
                'workout_completed_pct' => 33, // 2 out of 6 completed (Monday workouts marked completed above)
                'diet_completed_pct' => 50, // 2 out of 4 completed
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Jane Smith (user_id 2)
            [
                'user_id' => 2,
                'log_date' => Carbon::today()->subDays(4)->toDateString(),
                'weight' => 64.2,
                'workout_completed_pct' => 40,
                'diet_completed_pct' => 80,
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'user_id' => 2,
                'log_date' => Carbon::today()->subDays(3)->toDateString(),
                'weight' => 64.0,
                'workout_completed_pct' => 80,
                'diet_completed_pct' => 100,
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 2,
                'log_date' => Carbon::today()->subDays(2)->toDateString(),
                'weight' => 63.9,
                'workout_completed_pct' => 100,
                'diet_completed_pct' => 50,
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'user_id' => 2,
                'log_date' => Carbon::today()->subDays(1)->toDateString(),
                'weight' => 63.8,
                'workout_completed_pct' => 60,
                'diet_completed_pct' => 75,
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 2,
                'log_date' => Carbon::today()->toDateString(),
                'weight' => 63.7,
                'workout_completed_pct' => 40, // 2 out of 5
                'diet_completed_pct' => 50, // 2 out of 4
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('progress_logs')->whereIn('user_id', [1, 2])->delete();
        DB::table('diet_plans')->whereIn('user_id', [1, 2])->delete();
        DB::table('workout_plans')->whereIn('user_id', [1, 2])->delete();
        DB::table('payment_records')->whereIn('user_id', [1, 2, 3, 4])->delete();
        DB::table('crm_leads')->whereIn('id', [1, 2, 3, 4])->delete();
    }
};
