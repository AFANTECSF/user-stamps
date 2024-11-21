<?php

namespace UserStamps\Traits;

use Illuminate\Support\Facades\Auth;

trait HasUpdatedBy
{
    public static function bootHasUpdatedBy()
    {
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }
}