<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'interval',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('start_date', 'end_date');
    }
}
