<?php

namespace App\Middleware;

/** Role admin dan staff yang boleh lewat. Alias 'staff' di config/app.php. */
class StaffOnly extends EnsureRole
{
    protected function roles(): array
    {
        return ['admin', 'staff'];
    }
}

