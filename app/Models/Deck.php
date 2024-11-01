<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'teaser',
        'description',
        'cardsTeaser',
        'actionTeaser',
        'actionList',
        'actions',
        'characters',
        'bases',
        'clarifications',
        'suggestionTeaser',
        'synergy',
        'tips',
        'mechanics',
        'expansion',
        'effects',
        'playstyle',
        'image',
    ];
}
