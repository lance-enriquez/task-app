<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Table being associated with the model.
     *
     * @var string
     */
    protected $table = 't_users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Column to be used in the datetime parameter model creation.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * Column to be used in the datetime parameter model update.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'api_token'
    ];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return [
            'user_id',
            'username'
        ];
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'password'   => 'hashed'
    ];

    /**
     * Saves a User in the database.
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function saveUser(string $username, string $password): bool
    {
        return (new User([
            'username' => $username,
            'password' => Hash::make($password)
        ]))->save();
    }

    /**
     * Returns the first User given an ID.
     * Returns specific columns based on the $columns parameter.
     *
     * @param int $userId
     * @param array $columns
     * @return mixed
     */
    public function getUserWithId(int $userId, array $columns = [
        'user_id',
        'username',
        'api_token'
    ]): mixed
    {
        return User::where('user_id', $userId)->first($columns);
    }

    /**
     * Checks if the username and password stored in the database matches the parameters.
     *
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function checkPassword(string $username, string $password): mixed
    {
        $user = User::where('username', $username)->first();
        $storedPassword = (!empty($user)) ? $user['password'] : '';
        $status = Hash::check($password, $storedPassword);
        return $status ? $user : null;
    }

    /**
     * Generates an API token for a User.
     *
     * @param int $userId
     * @return string
     */
    public function generateApiToken(int $userId): string
    {
        $token = Str::random(60);
        $this->getUserWithId($userId)->forceFill([
            'api_token' => hash('sha256', $token)
        ])->save();
        return $token;
    }

    /**
     * Clears an API token of a User.
     *
     * @param int $userId
     * @return bool
     */
    public function clearApiToken(int $userId): bool
    {
        return $this->getUserWithId($userId)
                    ->forceFill([
                        'api_token' => null
                    ])
                    ->save();
    }

    /**
     * Validates if a User's API token matches the database.
     *
     * @param int $userId
     * @param string $apiToken
     * @return bool
     */
    public function validateApiToken(int $userId, string $apiToken): bool
    {
        $user = $this->getUserWithId($userId, ['api_token'])->toArray();
        $dbApiToken = Arr::get($user, 'api_token');
        return ($dbApiToken == hash('sha256', $apiToken));
    }
}
