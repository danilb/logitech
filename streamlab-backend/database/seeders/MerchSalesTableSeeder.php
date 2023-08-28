<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerchSalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Fancy Pants', 'Cool T-Shirt', 'Awesome Mug', 'Stylish Hat', 'Unique Keychain',
            'Sleek Backpack', 'Cozy Blanket', 'Trendy Hoodie', 'Classic Poster', 'Elegant Necklace'
        ];
        $streamlabsUserIds = DB::table('streamlabs_users')->pluck('id');

        for ($i = 0; $i < rand(300, 500); $i++) {
            $randomStreamlabsUserId = $streamlabsUserIds->random();
            DB::table('merch_sales')->insert([
                'streamlab_id' => $randomStreamlabsUserId,
                'item_name' => $items[rand(0, sizeof($items) - 1)],
                'amount' => rand(10, 200),
                'price' => rand(10, 100),
                'created_at' => Carbon::now()->subMonths(rand(0, 3))->subDays(rand(0, 90)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

}
