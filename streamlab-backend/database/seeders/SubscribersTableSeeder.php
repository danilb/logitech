<?php

namespace Database\Seeders;


use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptionTiers = ['Tier1', 'Tier2', 'Tier3'];

        $streamlabsUserIds = DB::table('streamlabs_users')->pluck('id');

        for ($i = 0; $i < rand(300, 500); $i++) {
            $randomStreamlabsUserId = $streamlabsUserIds->random();
            DB::table('subscribers')->insert([
                'streamlab_id' => $randomStreamlabsUserId,
                'name' => 'RandomUser'.$i,
                'subscription_tier' => $subscriptionTiers[array_rand($subscriptionTiers)],
                'created_at' => Carbon::now()->subMonths(rand(0, 3))->subDays(rand(0, 90)),
                'updated_at' => Carbon::now(),
            ]);
        }

    }
}
