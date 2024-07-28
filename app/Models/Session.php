<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable = [
        'session',
        'outlet_id',
        'color',
        'status',
    ];
    public function outlet(){
        return $this->belongsTo(Outlet::class);
    }
}