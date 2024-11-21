<?php

namespace UserStamps\Traits;

use Illuminate\Support\Facades\Auth;

trait HasDeletedBy
{
    public static function bootHasDeletedBy()
    {
        if (method_exists(static::class, 'bootSoftDeletes')) {
            static::deleting(function ($model) {
                if (Auth::check()) {
                    $model->deleted_by = Auth::id();
                    $model->save();
                }
            });
        }
    }
}
