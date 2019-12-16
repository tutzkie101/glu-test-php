<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class processor extends Model
{
    //
    protected $table = 'processor';
    protected $fillable = ['task_id','name','process_time'];
    public $timestamps = true;

}
