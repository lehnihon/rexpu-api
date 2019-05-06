<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AskedQuestions extends Model
{
    protected $fillable = [
        'question', 'answer'
    ];
    
}
