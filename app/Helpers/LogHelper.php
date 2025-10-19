<?php
namespace App\Helpers;
use App\Models\ActivityLog;

class LogHelper {
    public static function log(string $action, string $description, string $log_type = 'general', array $responseData = [])
    {
        ActivityLog::create([
            'log_type' => $log_type,
            'action' => $action,
            'description' => $description,
            'ip' => request()->ip(),
            'response_data' => $responseData ? json_encode($responseData) : null,
        ]);
    }
}
