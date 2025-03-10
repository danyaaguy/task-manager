<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use Illuminate\Notifications\Notifiable;
use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\ModelStates\HasStates;
use App\States\Task\TaskState;

class Task extends Model
{
    use HasFactory, Notifiable, Filterable, Sortable, HasStates;

    protected $fillable = [
        'title',
        'description',
        'state'
    ];

    protected $guarded = [
        'state'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'state' => TaskState::class,
        ];
    }

    /**
     * Get the users associated with the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
