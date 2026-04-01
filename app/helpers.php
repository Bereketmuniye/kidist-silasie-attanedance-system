<?php

use App\Services\ToasterService;

if (!function_exists('toaster')) {
    /**
     * Get the ToasterService instance.
     */
    function toaster(): ToasterService
    {
        return app(ToasterService::class);
    }
}
