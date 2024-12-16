<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
