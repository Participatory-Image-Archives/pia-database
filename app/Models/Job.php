<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'label',
    ];
}
