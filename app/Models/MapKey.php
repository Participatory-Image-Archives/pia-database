<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapKey extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;

    protected $fillable = [
        'label',
        'icon'
    ];

    /* relations */

    public function map()
    {
        return $this->belongsTo(Map::Class);
    }

    public function mapEntries()
    {
        return $this->belongsToMany(MapEntry::Class);
    }
}
