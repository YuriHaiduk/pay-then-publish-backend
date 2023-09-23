<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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
        'password' => 'hashed',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function hasActiveSubscription(): bool
    {
        return Subscription::where('user_id', $this->id)
            ->where('ends_at', '>', Carbon::now())
            ->exists();
    }

    public function activeSubscription(): Subscription
    {
        return $this->subscriptions()
            ->where('ends_at', '>', Carbon::now())
            ->first();
    }

    public function activatedPosts(): int
    {
        $activeSubscription = $this->activeSubscription();

        if (!$activeSubscription) {
            return 0;
        }

        $startDate = $activeSubscription->created_at;
        $endDate = $activeSubscription->ends_at;

        return $this->posts()
            ->where('is_active', true)
            ->whereBetween('activation_date', [$startDate, $endDate])
            ->count();
    }

    public function isAdmin()
    {
        return $this->role_id === Role::ROLE_ADMIN;
    }
}
