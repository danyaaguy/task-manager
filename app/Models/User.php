<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Spatie\ModelStates\HasStates;
use App\States\User\UserState;
use Spatie\Permission\Traits\HasRoles;


class User extends Model
{
    use HasFactory, Notifiable, Filterable, Sortable, HasStates, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $guarded = [
        'state'
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
            'password' => 'hashed',
            'state' => UserState::class,
        ];
    }

    /**
     * Get the tasks associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tasks(): belongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
