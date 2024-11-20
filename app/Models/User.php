<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        '_token'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        // Menambahkan event creating untuk mengatur kode_perusahaan otomatis
        static::creating(function ($user) {
            // Menambah 7 jam pada created_at
            // $user->email_verified_at = now()->addHours(7);
            $user->created_at = now()->addHours(7);
            $user->updated_at = now()->addHours(7);
        });

        // Automatically generate UUID for 'id' on model creation
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }
}
