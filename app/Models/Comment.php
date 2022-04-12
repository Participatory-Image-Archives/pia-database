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
    ];

    public function images()
    {
        return $this->belongsToMany(Image::Class);
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::Class);
    }

    public function albums()
    {
        return $this->belongsToMany(Album::Class);
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::Class);
    }
}
