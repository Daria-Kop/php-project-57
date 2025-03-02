<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    BelongsToMany
};

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status_id',
        'created_by_id',
        'assigned_to_id'
    ];
    
    protected $appends = ['author_name', 'status_name', 'executor_name', 'labels_names'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function getAuthorNameAttribute(): ?string
    {
        return $this->author->name;
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function getStatusNameAttribute()
    {
        return $this->status->name;
    }

    public function executor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id')->withDefault();
    }

    public function getExecutorNameAttribute()
    {
        return $this->executor ? $this->executor->name : null;
    }

    public function labels(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }

    public function getLabelsNamesAttribute()
    {
        return $this->labels->pluck('name')->toArray();
    }

    protected static function booted()
    {
        static::addGlobalScope('withRelations', function ($query) {
            $query->with(['author', 'status', 'executor', 'labels']);
        });
    }

    public function scopeFilterByStatus(Builder $query, string | null $statusId)
    {
        if ($statusId !== null && $statusId !== '0') {
            return $query->where('status_id', $statusId);
        }
        return $query;
    }

    public function scopeFilterByCreatedBy(Builder $query, string | null $createdById)
    {
        if ($createdById !== null && $createdById !== '0') {
            return $query->where('created_by_id', $createdById);
        }
        return $query;
    }

    public function scopeFilterByAssignedTo(Builder $query, string | null $assignedToId)
    {
        if ($assignedToId !== null && $assignedToId !== '0') {
            return $query->where('assigned_to_id', $assignedToId);
        }
        return $query;
    }
}
