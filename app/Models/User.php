<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'credits',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    //releation role model
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    //releation bet model
    public function bets()
    {
        return $this->hasMany(Bet::class);
    }

    //releation bet model
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    //releation transaction model
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function wonBetsCount()
    {
        return $this->bets->filter(function ($bet) {
            if ($bet->event->status != 'resolvido') {
                return false;
            }
            if ($bet->bet_type == 'winner' && $bet->bet_value == $bet->event->winner) {
                return true;
            }
            if ($bet->bet_type == 'games') {
                $loserGames = $bet->event->loser_games;
                $interval = $this->getGamesInterval($loserGames);
                return $bet->bet_value == $interval;
            }
            return false;
        })->count();
    }

    public function netEarnings()
    {
        $totalBetAmount = $this->bets->sum('bet_amount');
        $totalWinnings = 0;

        foreach ($this->bets as $bet) {
            if ($bet->event->status == 'resolvido') {
                if ($bet->bet_type == 'winner' && $bet->bet_value == $bet->event->winner) {
                    $losingBetsAmount = Bet::where('event_id', $bet->event_id)->where('bet_value', '!=', $bet->event->winner)->sum('bet_amount');
                    $winningBetsCount = Bet::where('event_id', $bet->event_id)->where('bet_value', $bet->event->winner)->count();
                    $totalWinnings += $bet->bet_amount + ($losingBetsAmount / $winningBetsCount);
                }
                if ($bet->bet_type == 'games') {
                    $loserGames = $bet->event->loser_games;
                    $interval = $this->getGamesInterval($loserGames);
                    if ($bet->bet_value == $interval) {
                        $losingBetsAmount = Bet::where('event_id', $bet->event_id)->where('bet_value', '!=', $interval)->where('bet_type', 'games')->sum('bet_amount');
                        $winningBetsCount = Bet::where('event_id', $bet->event_id)->where('bet_value', $interval)->where('bet_type', 'games')->count();
                        $totalWinnings += $bet->bet_amount + ($losingBetsAmount / $winningBetsCount);
                    }
                }
            }
        }

        return $totalWinnings - $totalBetAmount;
    }

    private function getGamesInterval($loserGames)
    {
        if ($loserGames >= 0 && $loserGames <= 4) {
            return '0-4';
        } elseif ($loserGames >= 5 && $loserGames <= 8) {
            return '5-8';
        } elseif ($loserGames >= 9 && $loserGames <= 12) {
            return '9-12';
        }
        return null;
    }

    
}
