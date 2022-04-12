<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;

    protected $fillable = [
        'salsah_id',
        'label',
        'signature',
        'description',
        'default_image',
        'embedded_video',
        'origin',
        'date_id',
    ];

    public function altLabels()
    {
        return $this->belongsToMany(AltLabel::Class);
    }

    public function date()
    {
        return $this->belongsTo(Date::Class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::Class);
    }

    public function literatures()
    {
        return $this->belongsToMany(Literature::Class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::Class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::Class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::Class);
    }

    public function notes()
    {
        return $this->belongsToMany(Note::Class);
    }

    public function maps()
    {
        return $this->belongsToMany(Map::Class);
    }

    /**
     * Convenience Functions
     */
    public function images_ids()
    {
        return $this->images()->allRelatedIds();
    }
}
