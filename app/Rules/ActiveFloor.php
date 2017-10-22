<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ActiveFloor implements Rule
{
    /**
     * The floors array.
     *
     * @var array
     */
    protected $floors = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->floors = config('elevator.floors');
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
        if (in_array($value, array_keys($this->floors))) {
            return false;
        }

        return $this->floors[$value];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Unexisting floor or under maintenance.';
    }
}
