<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    // Bu alanlar topluca doldurulabilir
    protected $fillable = ['name', 'surname', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
