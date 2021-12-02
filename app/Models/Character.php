<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'resourceURI',
        'thumbnail',
        'etag',
    ];

     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'etag',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function comics()
    {
        return $this->belongsToMany(Comic::class);
    }
}
