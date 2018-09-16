<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class DefaultTransformer extends TransformerAbstract
{
    /**
     * Transform object to array.
     *
     * @param  mixed $model
     * @return array
     */
    public function transform($model)
    {
        return $model->toArray();
    }
}
