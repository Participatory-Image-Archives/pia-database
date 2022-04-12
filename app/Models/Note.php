<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;

    protected $fillable = [
        'label',
        'description',
        'content'
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::Class);
    }
}
