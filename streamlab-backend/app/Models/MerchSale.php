<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchSale extends Model
{
    use HasFactory;

    public function streamlabsUser()
    {
        return $this->belongsTo(StreamlabsUser::class, 'streamlab_id');
    }
}
