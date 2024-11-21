<?php

namespace UserStamps;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class UserStampsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/user-stamps.php' => config_path('user-stamps.php'),
        ], 'config');
        Blueprint::macro('userStamps', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->unsignedBigInteger('updated_by')->nullable();
            if (collect($this->getColumns())->contains('deleted_at')) {
                $this->unsignedBigInteger('deleted_by')->nullable();
            }
            return $this;
        });

        Blueprint::macro('createdBy', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            return $this;
        });

        Blueprint::macro('updatedBy', function () {
            $this->unsignedBigInteger('updated_by')->nullable();
            return $this;
        });

        Blueprint::macro('deletedBy', function () {
            $this->unsignedBigInteger('deleted_by')->nullable();
            return $this;
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/user-stamps.php', 'user-stamps'
        );
    }
}