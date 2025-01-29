<?php

namespace App\Services;

abstract class BaseService
{
    protected function success($data = null, string $message = '')
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message
        ];
    }

    protected function error(string $message = '', $data = null)
    {
        return [
            'success' => false,
            'data' => $data,
            'message' => $message
        ];
    }
} 