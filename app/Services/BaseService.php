<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

abstract class BaseService
{
    /**
     * Validate params with respect to a sets of rules.
     *
     * @param  array  $params
     * @param  array  $rules
     * @return mixed
     */
    public function validate(array $params, array $rules)
    {
        $validator = app('validator')->make($params, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
