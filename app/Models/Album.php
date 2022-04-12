<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'salsah_id',
        'title',
        'label',
        'signature',
        'description',
        'date_id'
    ];

    public function date()
    {
        return $this->belongsTo(Date::Class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::Class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::Class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::Class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::Class);
    }
}
