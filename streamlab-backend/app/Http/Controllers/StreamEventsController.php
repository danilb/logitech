<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Subscriber;
use App\Models\Donation;
use App\Models\MerchSale;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StreamEventsController extends Controller
{
    public function getStreamEvents(Request $request)
    {
        $offset = $request->input('offset', 0); // Default offset is 0

        // Retrieve the first 100 records based on date
        $items = [];
        $followers = Follower::orderBy('created_at')->offset($offset)->limit(100)->get();
        $subscribers = Subscriber::orderBy('created_at')->offset($offset)->limit(100)->get();
        $donations = Donation::orderBy('created_at')->offset($offset)->limit(100)->get();
        $merchSales = MerchSale::orderBy('created_at')->offset($offset)->limit(100)->get();

        if (sizeof($followers) == 0 & sizeof($subscribers) == 0  & sizeof($donations) == 0
            & sizeof($merchSales) == 0) {
            return response()->json(['items' => '']);
        }

        for ($i = 0; $i <= 99; $i++) {

            $follower = ['follower' => ''];
            if (sizeof($followers) > $i && $followers[$i] !== null) {
                $follower = ['follower' => [
                    'name' => $followers[$i]->name,
                    'date_of_creation' => $followers[$i]->created_at,
                ]];
            }

            $subscriber = ['subscriber' => ''];
            if (sizeof($subscribers) > $i && $subscribers[$i] !== null) {
                $subscriber = ['subscriber' => [
                    'name' => $subscribers[$i]->name,
                    'tier' => $subscribers[$i]->subscription_tier,
                    'date_of_creation' => $subscribers[$i]->created_at,
                ]];
            }

            $donation = ['donation' => ''];
            if (sizeof($donations) > $i && $donations[$i] !== null) {

                $donnationFollower = Follower::where('streamlab_id', $donations[$i]->streamlab_id)->first();

                $donation = ['donation' => [
                    'follower_name' => $donnationFollower ? $donnationFollower->name : 'Hidden User',
                    'date_of_creation' => $donations[$i]->created_at ?? null,
                    'message' => $donations[$i]->donation_message ?? null,
                    'amount' => $donations[$i]->amount ?? null,
                    'currency' => $donations[$i]->currency ?? null,
                ]];
            }

            $merchSale = ['merchSale' => ''];
            if (sizeof($merchSales) > $i && $merchSales[$i] !== null) {

                $merchSaleFollower = Follower::where('streamlab_id', $merchSales[$i]->streamlab_id)->first();

                $merchSale = ['merchSale' => [
                    'follower_name' => $merchSaleFollower ? $merchSaleFollower->name : 'Hidden User',
                    'date_of_creation' => $merchSales[$i]->created_at ?? null,
                    'item_name' => $merchSales[$i]->item_name ?? null,
                    'amount' => $merchSales[$i]->amount ?? null,
                    'price' => $merchSales[$i]->price ?? null,
                ]];
            }


            $items[] = [
                $follower,
                $subscriber,
                $donation,
                $merchSale
            ];
        }

        return response()->json(['items' => $items]);
    }

    public function getUserStats(Request $request)
    {
        $userStats = [];

        // 1) Total revenue from Donations, Subscriptions & Merch sales in the past 30 days
        $totalRevenue = Donation::where('created_at', '<', Carbon::now()->subDays(30))
            ->sum('amount');

        $tier1Subscribers = Subscriber::where('created_at', '<', Carbon::now()->subDays(30))
                ->where('subscription_tier', 1)
                ->count() * 5;  // Tier1: $5

        $tier2Subscribers = Subscriber::where('created_at', '<', Carbon::now()->subDays(30))
                ->where('subscription_tier', 2)
                ->count() * 10; // Tier2: $10

        $tier3Subscribers = Subscriber::where('created_at', '<', Carbon::now()->subDays(30))
                ->where('subscription_tier', 3)
                ->count() * 15; // Tier3: $15

        $totalRevenue += $tier1Subscribers + $tier2Subscribers + $tier3Subscribers;

        $merchSalesRevenue = MerchSale::where('created_at', '<', Carbon::now()->subDays(30))
            ->sum('amount');

        $totalRevenue += $merchSalesRevenue;

        $userStats['total_revenue'] = $totalRevenue;

        // 2) Total amount of followers gained in the past 30 days
        $totalFollowers = Follower::where('created_at', '<', Carbon::now()->subDays(30))
            ->count();

        $userStats['total_followers_gained'] = $totalFollowers;

        // 3) Top 3 items that did the best sales in the past 30 days
        $topItems = MerchSale::select('item_name', DB::raw('SUM(amount) as total_amount'))
            ->where('created_at', '<', Carbon::now()->subDays(30))
            ->groupBy('item_name')
            ->orderByDesc('total_amount')
            ->limit(3)
            ->get();

        $userStats['top_items'] = $topItems;

        return response()->json($userStats);
    }
}

