<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // Nome real da tabela no banco (singular, conforme a migration)
    protected $table = 'profile';

    protected $fillable = [
        'type',
        'description',
        'user_id',
    ];

    /**
     * Perfil pertence a um usuário.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
