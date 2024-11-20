<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $fillable = ['id', 'name', 'username', 'status', 'hari', 'masuk', 'keluar', 'kegiatan', 'created_at', 'updated_at'];
}
