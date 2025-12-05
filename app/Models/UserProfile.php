<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// TODO: Add profile resource
class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'location', 'gender', 'date_of_birth', 'show_profile', 'show_online_status', 'show_comments'];

    /*
    ** Casts
    */

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'datetime',
            'show_profile' => 'boolean',
            'show_online_status' => 'boolean',
            'show_comments' => 'boolean',
        ];
    }

    /*
    ** Eloquent relationships
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    ** Accessors and attributes
    */

    protected $appends = ['age'];

    protected function age(): Attribute
    {
        return Attribute::get(function () {
            if ($this->date_of_birth !== null) {
                return Carbon::parse($this->date_of_birth)->age;
            } else {
                return null;
            }
        });
    }
}
