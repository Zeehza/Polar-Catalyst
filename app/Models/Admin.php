<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasUlids, Notifiable;

    protected $table = 'admins';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'id',
        'username',
        'passwordHash',
    ];

    protected $hidden = [
        'passwordHash',
    ];

    public function getAuthPasswordName(): string
    {
        return 'passwordHash';
    }

    public function getAuthPassword(): string
    {
        return $this->passwordHash;
    }
}
