<?php

namespace App\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class PasswordChecked implements Rule
{
    public $hashedPassword;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  bool  $password
     * @return bool
     */
    public function passes($attribute, $password)
    {
        return Hash::check($password, $this->hashedPassword);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le clé ne correspond pas!';
    }
}
