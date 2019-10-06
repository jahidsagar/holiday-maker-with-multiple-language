<?php

namespace App;

use DB;
use App\language;
use Illuminate\Database\Eloquent\Model;

class description extends Model
{
    //
    public function insertDescription($language , $title , $description)
    {
    	$language_data= language::all()->where('languageName',$language)->where('user_id',\Auth::user()->id)->first();
    	$var = new description();
    	$var->title = $title;
    	$var->description = $description;
    	$var->languageName = $language;
    	$var->language_id = $language_data->id;

    	if($var->save()) return $var->id;
    	return null;
    }
}
