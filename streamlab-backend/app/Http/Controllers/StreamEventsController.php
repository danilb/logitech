<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\Subscriber;
use App\Models\Donation;
use App\Models\MerchSale;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
                    'date_of_creation' => $subscribers[$i]->created_at,
                ]];
            }

            $donation = ['donation' => ''];
            if (sizeof($donations) > $i && $donations[$i] !== null) {

                $donnationFollower = Follower::where('streamlab_id', $donations[$i]->streamlab_id)->first();

                $donation = ['donation' => [
                    'follower_name' => $donnationFollower ? $donnationFollower->name : 'hidden',
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
                    'follower_name' => $merchSaleFollower ? $merchSaleFollower->name : 'hidden',
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
}

