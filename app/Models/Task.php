<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /**
     * Table being associated with the model.
     *
     * @var string
     */
    protected $table = 't_tasks';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'task_id';

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
        'user_id',
        'title',
        'content',
        'task_status_id',
        'is_draft',
        'is_deleted'
    ];

    /**
     * The attributes that define the default values.
     *
     * @var array<string, bool>
     */
    protected $attributes = [
        'is_draft'   => false,
        'is_deleted' => false
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];

    /**
     *
     *
     * @return HasMany
     */
    public function taskStatus(): HasMany
    {
        return $this->hasMany(
            TaskStatus::class,
            'task_status_id',
            'task_status_id'
        );
    }

    /**
     *
     *
     *
     * @param int $userId
     * @param int|null $taskId
     * @param int $taskStatusId
     * @param string $title
     * @param string $content
     * @param bool $isDraft
     * @return bool
     */
    public function saveTask(int $userId, ?int $taskId, int $taskStatusId, string $title, string $content, bool $isDraft): bool
    {
        return Task::updateOrCreate(
            [
                'user_id'        => $userId,
                'task_id'        => $taskId,
            ],
            [
                'task_status_id' => $taskStatusId,
                'title'          => $title,
                'content'        => $content,
                'is_draft'       => $isDraft
            ])->save();
    }

    /**
     *
     * @param int $userId
     * @param string|null $title
     * @param array $taskStatusIds
     * @return Collection
     */
    public function getUserTasks(int $userId, ?string $title = null, array $taskStatusIds = []): Collection
    {
        $tasks = $this->getUserTasksQuery($userId);
        $tasks = empty($title) ? $tasks : $tasks->where('title', 'LIKE', "%{$title}%");
        $tasks->whereIn('task_status_id', $taskStatusIds);
        return $tasks->with('taskStatus')
                     ->orderBy('updated_at', 'desc')
                     ->get();
    }

    /**
     *
     *
     * @param int $userId
     * @return Collection
     */
    public function getUserTrashTasks(int $userId): Collection
    {
        return $this->getUserTasksQuery($userId, true)
            ->with('taskStatus')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     *
     *
     * @param int $userId
     * @param int $taskId
     * @return bool
     */
    public function deleteTask(int $userId, int $taskId): bool
    {
        $task = Task::where([
                         ['user_id', '=', $userId],
                         ['task_id', '=', $taskId]
                     ])
                     ->first();

        if (!empty($task)) {
            if ($task->is_deleted) {
                return $task->delete();
            } else {
                $task->is_deleted = true;
                return $task->save();
            }
        }

        return false;
    }

    /**
     *
     *
     * @param int $userId
     * @param int $taskId
     * @return bool
     */
    public function restoreTask(int $userId, int $taskId): bool
    {
        $task = $this->getUserTasksQuery($userId, true)
                     ->where('task_id', $taskId)
                     ->first();

        if (!empty($task)) {
            $task->is_deleted = false;
            return $task->save();
        }

        return false;
    }

    /**
     *
     *
     * @param int $userId
     * @param bool $isDeleted
     * @return mixed
     */
    private function getUserTasksQuery(int $userId, bool $isDeleted = false): mixed
    {
        return Task::where([
            ['user_id', '=', $userId],
            ['is_deleted', '=', $isDeleted]
        ]);
    }
}
