<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class TaskStatus extends Model
{
    /**
     * Table being associated with the model.
     *
     * @var string
     */
    protected $table = 't_task_status';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'task_status_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Returns a collection of TaskStatus.
     *
     * @return Collection
     */
    public static function getTaskStatus(): Collection
    {
        return TaskStatus::orderBy('task_status_id', 'asc')->get();
    }
}
