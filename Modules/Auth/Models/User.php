<?php

namespace Modules\Auth\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Modules\Auth\Database\Factories\UserFactory;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    public const TABLE = 'users';
    public const MORPH_NAME = 'user';

    protected $table = self::TABLE;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /** @var array<int, string> */
    protected $hidden = [
        'password',
    ];

    public function createToken(
        ?DateTimeInterface $expiresAt = null
    ): NewAccessToken {
        $plainTextToken = $this->generateTokenString();

        /** @var PersonalAccessToken $token */
        $token = $this->tokens()->create([
            'token' => hash('sha256', $plainTextToken),
            'expires_at' => $expiresAt,
            'name' => 'api',
        ]);

        return new NewAccessToken($token, $plainTextToken);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => Str::lower($value)
        );
    }
}
