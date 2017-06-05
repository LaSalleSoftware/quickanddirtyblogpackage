<?php

namespace Lasallesoftware\Quickanddirtyblog\Models;

/**
 *
 * Internal API package for the LaSalle Content Management System, based on the Laravel 5 Framework
 * Copyright (C) 2015 - 2016  The South LaSalle Trading Corporation
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @package    Very quick and dirty blog package based on my LaSalle Software v1
 * @link       http://LaSalleSoftware.ca
 * @copyright  (c) 2017, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      bob.bloom@lasallesoftware.ca
 *
 */

// Laravel classes
use Illuminate\Database\Eloquent\Model;

// Third party classes
use Carbon\Carbon;

// FOR VOYAGER ADMIN
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Traits\Translatable;

/**
 * Class Post
 * @package Lasallesoftware\Quickanddirtyblog\Models
 */
class Post extends Model
{
    use Translatable;

    /**
     * The database table used by the model.
     *
     * The convention is plural -- and plural is assumed.
     *
     * Lowercase.
     *
     * @var string
     */
    public $table = "posts";

    /**
     * Which fields may be mass assigned
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 'meta_description', 'enabled', 'featured_image', 'publish_on', 'created_at', 'updated_at'
    ];

    /**
     * FOR VOYAGER ADMIN
     */
    //protected $guarded = [];
    //protected $translatable = ['title', 'excerpt', 'content', 'slug', 'meta_description'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    // SANITATION RULES PROPERTIES

    /**
     * Sanitation rules for Create (INSERT)
     *
     * @var array
     */
    public $sanitationRulesForCreate = [
        'title'            => 'trim|strip_tags',
        'slug'             => 'trim',
        'canonical_url'    => 'trim',
        'content'          => 'trim',
        'excerpt'          => 'trim|strip_tags',
        'meta_description' => 'trim',
        'featured_image'   => 'trim',
    ];

    /**
     * Sanitation rules for UPDATE
     *
     * @var array
     */
    public $sanitationRulesForUpdate = [
        'title'            => 'trim|strip_tags',
        'slug'             => 'trim',
        'canonical_url'    => 'trim',
        'content'          => 'trim',
        'excerpt'          => 'trim|strip_tags',
        'meta_description' => 'trim',
        'featured_image'   => 'trim',
    ];


    // VALIDATION RULES PROPERTIES

    /**
     * Validation rules for  Create (INSERT)
     *
     * NOTE: content field has 7 chars when blank!
     *
     * @var array
     */
    public $validationRulesForCreate = [
        'title'            => 'required|min:4',
        'categories'       => 'required',
        'content'          => 'required|min:11',
    ];

    /**
     * Validation rules for UPDATE
     *
     * NOTE: content field has 7 chars when blank!
     *
     * @var array
     */
    public $validationRulesForUpdate = [
        'title'            => 'required|min:4',
        'categories'       => 'required',
        'content'          => 'required|min:11',
    ];


    ///////////////////////////////////////////////////////////////////
    //////////////        RELATIONSHIPS             ///////////////////
    ///////////////////////////////////////////////////////////////////

    /*
    * Many to many relationship with categories.
    *
    * Method name must be:
    *    * the model name,
    *    * NOT the table name,
    *    * singular;
    *    * lowercase.
    *
    * @return Eloquent
    */
    public function category()
    {
        //return $this->belongsToMany('Lasallesoftware\Quickanddirtyblog\Models\Category', 'post_category');
        return $this->hasMany('Lasallesoftware\Quickanddirtyblog\Models\Category', 'post_category');
    }

    // *** FOR VOYAGER ADMIN ***
    public function categories(){
        return $this->belongsToMany(Category::class, 'post_category');
    }

    /*
     * Many to many relationship with tags.
     *
     * Method name must be:
     *    * the model name,
     *    * NOT the table name,
     *    * singular;
     *    * lowercase.
     *
     * @return Eloquent
     */
    public function tag()
    {
        return $this->hasMany('Lasallesoftware\Quickanddirtyblog\Models\Tag', 'post_tag');
    }

    // *** FOR VOYAGER ADMIN ***
    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    /*
     * One to one relationship with user_id.
     *
     * Method name must be:
     *    * the model name,
     *    * NOT the table name,
     *    * singular;
     *    * lowercase.
     *
     * @return Eloquent
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /*
     * One to many relationship with postupdate_id
     *
     * Method name must be:
     *    * the model name,
     *    * NOT the table name,
     *    * singular;
     *    * lowercase.
     *
     * @return Eloquent
     */
    public function postupdate()
    {
        return $this->hasMany('Lasallesoftware\Quickanddirtyblog\Models\Postupdate');
    }


    ///////////////////////////////////////////////////////////////////
    //////////////        QUERY SCOPES              ///////////////////
    ///////////////////////////////////////////////////////////////////

    /**
 * Scope a query to only published scopes.
 *
 * @param \Illuminate\Database\Eloquent\Builder $query
 *
 * @return \Illuminate\Database\Eloquent\Builder
 */
    public function scopePublished(Builder $query)
    {
        $now = Carbon::now();

        return $query->where([
            ['enabled', '=', 1],
            ['publish_on', '<=', $now],
        ]);

    }

    /**
     * Scope a query to only "sticky" posts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSticky(Builder $query)
    {
        return $query->where([
            ['sticky', '=', 1],
        ]);

    }

    /**
     * Scope a query to only posts that are not "sticky".
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotsticky(Builder $query)
    {
        return $query->where([
            ['sticky', '=', 0],
        ]);

    }

    ///////////////////////////////////////////////////////////////////
    //////////////        FOR VOYAGER ADMIN         ///////////////////
    ///////////////////////////////////////////////////////////////////
    public function save(array $options = [])
    {

        $this->created_by = Auth::user()->id;
        $this->updated_by = Auth::user()->id;

        $this->lookup_workflow_status_id = 1;

        if (($this->meta_description == "") || (!isset($this->meta_description))) {
            $this->meta_description = $this->excerpt;
        }

        $this->canonical_url = env('APP_URL') . '/' . $this->slug;

        parent::save();
    }


    /**
     *   Method for returning specific thumbnail for post.
     *
     *  FOR VOYAGER ADMIN
     */
    public function thumbnail($type)
    {
        // We take image from posts field
        $image = $this->attributes['image'];
        // We need to get extension type ( .jpeg , .png ...)
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        // We remove extension from file name so we can append thumbnail type
        $name = rtrim($image, '.'.$ext);
        // We merge original name + type + extension
        return $name.'-'.$type.'.'.$ext;
    }
}