<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class Monthvalidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $appId;
    public function __construct($id)
    {
        //
        $this->appId = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        $var = count(DB::table('months')->where('monthName',$value)->where('package_id',$this->appId)->get());
        if($var > 0) return false;
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The month already taken .';
    }
}
