<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamlabsUser extends Model
{
    use HasFactory;

    protected $fillable = ['streamlab_id'];

    public function followers()
    {
        return $this->hasMany(Follower::class, 'streamlab_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class, 'streamlab_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'streamlab_id');
    }

    public function merchSales()
    {
        return $this->hasMany(MerchSale::class, 'streamlab_id');
    }
}

