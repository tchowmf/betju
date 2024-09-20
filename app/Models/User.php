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
        // Obtém o total de depósitos (soma de todas as transações de depósito)
        $totalDeposits = $this->transactions()
                              ->where('transaction_type', 'deposit')
                              ->sum('transaction_value');
    
        // Obtém o total de retiradas (soma de todas as transações de retirada)
        $totalWithdrawals = $this->transactions()
                                 ->where('transaction_type', 'withdraw')
                                 ->sum('transaction_value');
    
        // Saldo atual do usuário
        $currentBalance = $this->credits;
    
        // Calcula o lucro líquido: saldo atual - (total depositado - total retirado)
        return $currentBalance + ($totalWithdrawals - $totalDeposits);
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
