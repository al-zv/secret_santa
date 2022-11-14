<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;


class SecretSanta extends Model
{
    use HasFactory;

    /**
     * Обратная связь один к одному с моделью участники
     */

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
