<?php

namespace App\Rules;

use App\Models\AttributeTranslation;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttributeName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $name;
    private $id;

    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    //  $value >> qty
    public function passes($attribute, $value)
    {

        if ($this->id)
            $attribute = AttributeTranslation::where('name', $value)->where('attribute_id', '!=', $this->id)->first();
        else
            $attribute = AttributeTranslation::where('name', $value)->first();


        if ($attribute)
            return false;
        else
            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'القيمة موجودة من قبل';
    }
}
