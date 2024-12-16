<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public $timestamps = false;

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
