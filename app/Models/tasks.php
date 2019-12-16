<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    //
    protected $table = 'tasks';
    protected $fillable = ['submitters_id','package','priority'];
    public $timestamps = true;
}
