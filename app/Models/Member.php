<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SecretSanta;

class Member extends Model
{
    use HasFactory;

    /**
     * Связь один к одному с моделью тайный санта
     */

    public function secretSanta()
    {
        return $this->hasOne(SecretSanta::class);
    }
}
