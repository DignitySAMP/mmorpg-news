<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

// TODO: Set up Fortify 2FA
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_location',
        'profile_gender',
        'profile_dob',
        'privacy_online_status',
        'privacy_articles',
        'privacy_comments'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
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
            'profile_dob' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    ** Eloquent relationships
    */

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    /*
    ** Accessors and attributes
    */

    protected $appends = ['status', 'age'];

    protected function status(): Attribute
    {
        return Attribute::get(function () {
            if (Auth::check()) {
                if ($this->updated_at > now()->subMinutes(5)) {
                    return 'Online';
                } 
                elseif ($this->updated_at > now()->subMinutes(10)) {
                    return 'Away';
                }
            }
    
            return 'Offline';
        });
    }

    protected function age(): Attribute 
    {
        return Attribute::get(function() {
            if($this->profile_dob !== null) {
                return Carbon::parse($this->profile_dob)->age;
            }
            else return null;
        });
    }
}
