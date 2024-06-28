<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    use HasFactory;

    //table
    protected $table = 'bets';

    //attributes
    protected $fillable = [
        'user_id',
        'bet_type',
        'bet_value',
        'bet_amount',
    ];

    //releation user model
    public function user()
    {
        return $this->belongsTo(User::class);    
    }
}
