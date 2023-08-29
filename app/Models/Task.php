<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasUuid;

    protected $fillable = [
        'title', 'description', 'due_date', 'status',
        'category_id', 'user_id'
    ];

    protected $casts = [
        'due_date'  => 'date:Y-m-d',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}