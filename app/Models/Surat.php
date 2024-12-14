<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat',
        'user_id',
        'keperluan',
        'lampiran_ktp',
        'lampiran_lain',
        'status',
        'catatan_admin',
        'catatan_rt',
        'catatan_rw',
    ];

    protected $casts = [
        'lampiran_lain' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userData()
    {
        return $this->hasOne(UserData::class);
    }
}
