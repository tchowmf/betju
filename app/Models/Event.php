<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'player1',
        'player2',
        'loser_games',
        'status',
        'time_limit'
    ];

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
}
