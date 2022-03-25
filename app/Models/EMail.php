<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EMail extends Model
{
    use HasFactory;
protected $table = 'mails';
   protected $fillable = ['email', 'password'];
}
