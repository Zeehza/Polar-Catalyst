<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasUlids;

    protected $table = 'contact_submissions';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'name',
        'company',
        'email',
        'message',
        'emailSent',
        'discordSent',
        'isRead',
    ];

    protected $casts = [
        'emailSent' => 'boolean',
        'discordSent' => 'boolean',
        'isRead' => 'boolean',
        'createdAt' => 'datetime',
    ];
}
