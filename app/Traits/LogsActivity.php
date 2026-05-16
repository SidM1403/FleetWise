<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected function logActivity($action)
    {
        $description = $this->getActivityDescription($action);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => $action,
            'model_type'  => class_basename($this),
            'model_id'    => $this->id,
            'description' => $description,
        ]);
    }

    protected function getActivityDescription($action)
    {
        $name = class_basename($this);
        $identifier = $this->vehicle_number ?? $this->name ?? $this->id;

        return "{$name} '{$identifier}' was {$action}.";
    }
}
