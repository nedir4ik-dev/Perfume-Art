<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'user_id',       // TÄZE: Ulanyjyny loga baglamak üçin hökmany meýdança
        'ip_address',
        'user_agent',
        'url',
        'referer',
        'method',
        'status_code',
        'level',
        'error_message',
        'payload',
        'visit_count',
        'last_activity',
        'duration'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'payload'       => 'array',
    ];

    /**
     * TÄZE: Hereketi eden ulanyjy (User) bilen baglanyşyk (Relationship)
     * Bu metod Controller-däki with('user') çagyryşynyň kemsiz işlemegini üpjün eder.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
