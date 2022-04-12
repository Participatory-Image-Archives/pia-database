<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'label',
        'comment',
        'file_name',
        'original_file_name',
        'base_path',
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::Class);
    }

    public function aggregations()
    {
        return $this->belongsToMany(Aggregation::Class);
    }
}
