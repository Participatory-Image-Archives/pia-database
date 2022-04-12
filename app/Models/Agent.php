<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    protected $connection= 'pia';

    use SoftDeletes;
    
    protected $fillable = [
        'salsah_id',

        'title',
        'name',
        'given_name',
        'family_name',

        'family',
        'description',

        'birthplace_id',
        'deathplace_id',
        'birthdate_id',
        'deathdate_id',

        'gnd_id',
        'gnd_uri'
    ];

    public function images()
    {
        return $this->belongsToMany(Image::Class);
    }

    public function birthplace()
    {
        return $this->belongsTo(Place::Class, 'birthplace_id');
    }
    public function deathplace()
    {
        return $this->belongsTo(Place::Class, 'deathplace_id');
    }

    public function birthdate()
    {
        return $this->belongsTo(Date::Class, 'birthdate_id');
    }
    public function deathdate()
    {
        return $this->belongsTo(Date::Class, 'deathdate_id');
    }
}
