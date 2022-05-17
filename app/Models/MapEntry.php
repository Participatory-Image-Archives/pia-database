<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapEntry extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;

    protected $fillable = [
        'label',
        'description',
        'type',
        'complex_data',
        'map_layer_id',
        'place_id',
        'image_id'
    ];

    /* relations */

    public function map()
    {
        return MapLayer::find($this->map_layer_id)->map();
    }

    public function mapLayer()
    {
        return $this->belongsTo(MapLayer::Class);
    }

    public function mapKeys()
    {
        return $this->belongsToMany(MapKey::Class);
    }

    public function place()
    {
        return $this->belongsTo(Place::Class);
    }

    public function image()
    {
        return $this->belongsTo(Image::Class);
    }
}
