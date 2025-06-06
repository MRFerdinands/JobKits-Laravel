<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'address' => 'array',
            'experiences' => 'array',
            'educations' => 'array',
            'skills' => 'array',
            'extra_info' => 'array',
            'documents' => 'array',
            'sent_type' => 'string',
            'status' => 'string',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'interviewed' => 'Wawancara',
            'rejected' => 'Ditolak',
            'hired' => 'Diterima',
            default => $this->status,
        };
    }

    public function getSentTypeLabelAttribute()
    {
        return match ($this->sent_type) {
            'online' => 'Online',
            'offline' => 'Offline',
            default => $this->sent_type,
        };
    }
}
