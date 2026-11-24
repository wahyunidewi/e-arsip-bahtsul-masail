<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arsipbahtsulmasail extends Model
{
    use HasFactory;
    protected $table = 'arsip_bahtsul_masail';
    protected $guarded = ['id'];
}
