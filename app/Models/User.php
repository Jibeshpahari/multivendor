<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Override;

#[Fillable(['name', 'email', 'password', 'phone', 'avatar', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    protected $primaryKey = 'uuid';

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

    public function vendorProfile(): HasOne
    {
        return $this->hasOne(VendorProfile::class, 'user_id', 'uuid');
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, function (Builder $query) use ($term) {
            $like = '%' . addcslashes($term, '%_\\') . '%';

            $query->where(
                fn($q) => $q
                    ->where('name', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhereIn('uuid', VendorProfile::select('user_id')->where('store_name', 'like', $like))
            );
        });
    }



}
