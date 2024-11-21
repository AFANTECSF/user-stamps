<?php

namespace UserStamps\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait HasUserStamps
{
    public static function bootHasUserStamps()
    {
        static::creating(function ($model) {
            if (!$model->created_by && Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        if (method_exists(static::class, 'bootSoftDeletes')) {
            static::deleting(function ($model) {
                if (Auth::check()) {
                    $model->deleted_by = Auth::id();
                    $model->save();
                }
            });
        }

        if (Config::get('user-stamps.handle_query_builder_updates', false)) {
            static::addGlobalScope('user_stamps', function ($builder) {
                $builder->beforeUpdate(function ($query) {
                    // Only add updated_by if not explicitly set in the update
                    $updates = $query->getQuery()->updates ?? [];
                    if (Auth::check() && !array_key_exists('updated_by', $updates)) {
                        $updates['updated_by'] = Auth::id();
                        $query->getQuery()->updates = $updates;
                    }
                });
            });
        }
    }
}