<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CurriculumVitae extends Model
{
    use HasUuids;

    public function casts(): array
    {
        return [
            'experiences' => 'array',
            'educations' => 'array',
            'skills' => 'array',
            'extra_info' => 'array',
        ];
    }
}
