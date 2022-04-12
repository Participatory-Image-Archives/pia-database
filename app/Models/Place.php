<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'label',
        'geonames_id',
        'geonames_uri',
        'geonames_code',
        'geonames_code_name',
        'geonames_division_level',
        'wiki_uri',
        'geometry',
        'latitude',
        'longitude',
        'origin'
    ];

    public function images()
    {
        return $this->hasMany(Image::Class);
    }
}
