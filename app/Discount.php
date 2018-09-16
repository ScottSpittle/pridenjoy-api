<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $dates = [
      'validFrom',
      'validTo'
    ];

    public $timestamps = false;

    public static function create($code) {
        $discount = new Discount();
        $discount->discountCode = $code;

        return $discount;
    }

    public function setActive($val) {
        $this->discountActive = $val;

        return $this;
    }

    public function setPercent($val) {
        $this->discountPercent = $val;

        return $this;
    }

    public function setValidFrom($val) {
        $this->validFrom = $val;

        return $this;
    }

    public function setValidTo($val) {
        $this->validTo = $val;

        return $this;
    }

    public function setFlat($val) {
        $this->discountFlat = $val;

        return $this;
    }

    public function setSingleUseOnly($val) {
        $this->singleUseOnly = $val;

        return $this;
    }
}
