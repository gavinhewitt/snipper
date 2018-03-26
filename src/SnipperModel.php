<?php

namespace GavinHewitt\Snipper\Models;

use Illuminate\Database\Eloquent\Model;

class SnipperModel extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'snippets';
    protected $fillable = [
        'name',
        'source_url',
        'content',
    ];

    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

//    public function tags()
//    {
//        return $this->belongsToMany(
//            Tag::class,
//            'word_has_tag',
//            'word_id',
//            'tag_id')->orderBy('slug');
//    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

//    public function scopeByFirstLetters($query, $letter)
//    {
//        return $query->where('word', 'LIKE', $letter .'%');
//    }


    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

//    public function getWikipediaLinkAttribute()
//    {
//        return 'https://nl.wikipedia.org/wiki/'. $this->wikipedia;
//    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}