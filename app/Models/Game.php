<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    const STATS = [
        'kill',
        'death',
        'assist',
        'damage',
        'accuracy',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function scopeOfUser($query, $user_id){
        return $query->where("user_id", $user_id);
    }

    public function scopeOfCharacter($query, $character_id){
        return $query->where("character_id", $character_id);
    }

    public function scopeOfCharacterName($query, $character_name){
        return $query->where("character_id", Character::where("name", $character_name)->first()->id);
    }
}
