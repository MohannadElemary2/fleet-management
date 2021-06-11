<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function messages()
    {
        $validationMessages = [];

        if ($this->validations) {
            foreach ($this->validations as $validation) {
                $validationMessages[$validation] = __(
                    "$this->label/validations.". str_replace('.', ':', $validation)
                );
            }
        }

        return $validationMessages;
    }
}
