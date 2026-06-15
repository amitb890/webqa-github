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
        
        // Trim whitespace from the URL
        $value = trim($value);
        
        // Return false if empty after trimming
        if (empty($value)) {
            return false;
        }
        
        if (str_starts_with($value, '@') || str_contains($value, '@http')) {
            return false;
        }

        $parsed = parse_url($value);
        if (!isset($parsed['scheme']) || !in_array(strtolower($parsed['scheme']), ['http', 'https'], true)) {
            return false;
        }

        $host = $parsed['host'] ?? '';
        if ($host === '' || $host === 'www.' || !str_contains($host, '.')) {
            return false;
        }

        return true;
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
