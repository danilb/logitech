<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $messages = ['Thank you for your content!', 'You\'re awesome!',
            'Want more!', 'Thank you for being awesome'];

        $currencies = ['USD', 'EUR', 'GBP'];

        $streamlabsUserIds = DB::table('streamlabs_users')->pluck('id');

        for ($i = 0; $i < rand(300, 500); $i++) {
            $randomStreamlabsUserId = $streamlabsUserIds->random();

            DB::table('donations')->insert([
                'streamlab_id' => $randomStreamlabsUserId,
                'amount' => rand(10, 1000),
                'currency' => $currencies[array_rand($currencies)],
                'donation_message' => $messages[rand(0, 3)],
                'created_at' => Carbon::now()->subMonths(rand(0, 3))->subDays(rand(0, 90)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
