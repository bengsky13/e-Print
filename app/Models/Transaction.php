<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'amount',
        'status',
        'qr',
        'trx_uuid',
    ];

    public function session(){
        return $this->belongsTo(Session::class);
    }
}