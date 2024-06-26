<?php

namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;

abstract class Presenter
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        return null;
    }
}
