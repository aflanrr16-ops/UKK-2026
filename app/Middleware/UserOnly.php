<?php

namespace App\Middleware;

/** Hanya role user (default) yang boleh lewat. Alias 'user' di config/app.php. */
class UserOnly extends EnsureRole
{
    protected function roles(): array
    {
        return ['user'];
    }
}

