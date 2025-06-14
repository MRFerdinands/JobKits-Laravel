<?php

namespace App\Builder;

use Closure;

class CVBuilder
{
    protected array $profiles = [
        'picture' => '',
        'name' => '',
        'phone' => '',
        'email' => '',
        'birth_loc' => '',
        'birth_date' => '',
    ];

    public static function make(string $name)
    {
        $instance = new static();

        if ($name) {
            $instance->profiles['name'] = $name;
        }

        return $instance;
    }

    public function picture(string $file_path)
    {
        $this->profiles['picture'] = $file_path;

        return $this;
    }

    public function phone(string $file_path)
    {
        $this->profiles['phone'] = $file_path;

        return $this;
    }

    public function toString()
    {
        return implode(', ', $this->profiles);
    }
}
