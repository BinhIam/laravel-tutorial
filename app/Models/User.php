<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Cacheable;
use App\Traits\RegisterClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

/**
 * class User models
 * author: nguyen.binh@jvb-corp.com
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, RegisterClass, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'class_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Search return
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email
        ];
    }


    /**
     * Generate key for caching
     * @return
     */
    public function getCacheKey()
    {
        // Example: App\User/1-13134234
        return sprintf("%s/%s-%s",
            get_class($this),
            $this->id,
            $this->updated_at
        );
    }
}
