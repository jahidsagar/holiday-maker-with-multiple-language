<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class language extends Model
{
    //user specific languages
    public function all_languages()
    {
    	return language::all()->where('user_id',\Auth::user()->id);
    }
}
