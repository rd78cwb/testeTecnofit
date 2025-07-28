<?php

namespace App\model;

class PersonalRecord extends BaseModel
{
    public int $id;
    public int $user_id;
    public int $movement_id;
    public float $value;
    public string $date;

    public function __construct(int $id, int $user_id, int $movement_id, float $value, string $date)
    {
        $this->id          = $id;
        $this->user_id     = $user_id;
        $this->movement_id = $movement_id;
        $this->value       = $value;
        $this->date        = $date;
    }
}
