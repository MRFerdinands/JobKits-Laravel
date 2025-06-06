<?php

namespace App\Dto;

class EducationDTO
{
    public string $institution;
    public string $major;

    public function __construct(string $institution, string $major)
    {
        $this->institution = $institution;
        $this->major = $major;
    }
}
