<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomURL implements Rule
{
    private $attribute = false;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $this->attribute = $attribute; 
        return preg_match("/(http|https):\/\/[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&=]*)/i", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     * @param  mixed  $value
     */
    public function message()
    {
        if($this->attribute === "urlsList"){
            return "All URL's must be valid.";
        }else{
            return "The :attribute must be a valid URL.";
        }
    }
}
