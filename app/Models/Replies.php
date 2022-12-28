<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replies extends Model 
{
    use HasFactory;
    protected $primaryKey = 'reply_id';
    protected $guarded = [];

    public function Thread() {
        return $this->belongsTo('App\Models\Threads','reply_id');
    }
}