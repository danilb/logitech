<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $streamlabsUserIds = DB::table('streamlabs_users')->pluck('id');

        for ($i = 0; $i < rand(300, 500); $i++) {
            $randomStreamlabsUserId = $streamlabsUserIds->random();

            DB::table('followers')->insert([
                'streamlab_id' => $randomStreamlabsUserId,
                'name' => 'RandomUser' . $i,
                'created_at' => Carbon::now()->subMonths(rand(0, 3))->subDays(rand(0, 90)),
                'updated_at' => Carbon::now(),
            ]);
        }

    }
}
