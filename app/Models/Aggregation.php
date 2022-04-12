<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aggregation extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'label',
        'origin',
        'description',
        'signatures'
    ];

    public function documents()
    {
        return $this->belongsToMany(Document::Class);
    }
}
