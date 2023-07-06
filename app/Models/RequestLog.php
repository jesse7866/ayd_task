<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

    protected $table = 'request_logs';

    public const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = [
        'query' => 'json',
        'ip' => 'json',
        'headers' => 'json',
        'request_body' => 'json',
        'response_body' => 'json',
    ];
}
