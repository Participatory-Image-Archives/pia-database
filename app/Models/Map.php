<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Map extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;

    protected $fillable = [
        'label',
        'description',
        'tiles',
        'origin'
    ];
    
    /* relations */

    public function mapKeys()
    {
        return $this->hasMany(MapKey::Class)->orderBy('label');
    }

    public function mapLayers()
    {
        return $this->hasMany(MapLayer::Class)->orderBy('label');
    }

    public function linkedLayers()
    {
        return $this->belongsToMany(MapLayer::Class, 'map_linked_map_layer');
    }

    public function mapEntries()
    {
        return $this->hasManyThrough(MapEntry::Class, MapLayer::Class)->orderBy('label');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::Class);
    }
}
