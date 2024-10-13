<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class ToDoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'keterangan',
        'date',    
        'pesan',
        'user_id',
        'attendance_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function toDoList() {
        return $this->belongsTo(ToDoList::class, 'attendance_id', 'id');
    }
}