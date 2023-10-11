<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'worker_id',
        'price',
        'content',
        'status',
        'rejected_reason',
    ];
    public function Worker(){
    return $this->belongsTo(Worker::class);
    }
    public function postPhotos(){
    return $this->hasMany(PostPhoto::class);
    }
}
