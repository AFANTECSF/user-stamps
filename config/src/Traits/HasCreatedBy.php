<?php

namespace UserStamps\Traits;

use Illuminate\Support\Facades\Auth;

trait HasCreatedBy
{
    public static function bootHasCreatedBy()
    {
        static::creating(function ($model) {
            if (!$model->created_by && Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }
}