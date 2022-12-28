<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Threads extends Model 
{
    use HasFactory;
    protected $primaryKey = 'thread_id';
    protected $guarded = [];

    public function board_name()
    {
        return $this->hasMany(Board::class,'tag','board');
    }
}
