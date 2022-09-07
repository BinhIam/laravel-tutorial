<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RegisterClass
{
    /**
     * Relationship between User and Classes
     * @return BelongsToMany
     */
    public function registerClass(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'class', 'user_id', 'class_user_id');
    }
}
