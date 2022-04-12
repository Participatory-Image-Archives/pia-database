<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'salsah_id',

        'oldnr',
        'signature',
        'title',
        'sequence_number',

        'date_id',
        'place_id',
        'copyright_id',

        'file_name',
        'original_file_name',
        'base_path',

        'object_type_id',
        'model_type_id',
        'format_id',
    ];

    public function objectType()
    {
        return $this->belongsTo(ObjectType::Class);
    }

    public function modelType()
    {
        return $this->belongsTo(ModelType::Class);
    }

    public function format()
    {
        return $this->belongsTo(Format::Class);
    }

    public function place()
    {
        return $this->belongsTo(Location::Class);
    }

    public function copyright()
    {
        return $this->belongsTo(Agent::Class, 'copyright_id');
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::Class);
    }

    public function keywords()
    {
        return $this->belongsToMany(Keyword::Class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::Class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::Class);
    }
}
