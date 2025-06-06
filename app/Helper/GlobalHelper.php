<?php

namespace App\Helper;

class GlobalHelper
{
    public static function formatAddress(array $address)
    {
        return sprintf(
            '%s, RT-%s/RW-%s, %s, %s, %s, %s.',
            $address['address'] ?? '',
            $address['rt'] ?? '-',
            $address['rw'] ?? '-',
            $address['village'] ?? '',
            $address['district'] ?? '',
            $address['regency'] ?? '',
            $address['province'] ?? ''
        );
    }
}
