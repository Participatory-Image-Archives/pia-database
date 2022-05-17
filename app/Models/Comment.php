<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $connection= 'pia';
    
    use SoftDeletes;
    
    protected $fillable = [
        'comment',
        'image_id',
        'collection_id',
        'album_id',
        'agent_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::Class);
    }

    public function collection()
    {
        return $this->belongsTo(Collection::Class);
    }

    public function album()
    {
        return $this->belongsTo(Album::Class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::Class);
    }
}
