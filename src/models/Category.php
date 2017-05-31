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
use Illuminate\Database\Eloquent\Builder;

// FOR VOYAGER ADMIN
use Illuminate\Support\Facades\Auth;

/**
 * Class Category
 * @package Lasallesoftware\Quickanddirtyblog\Models
 */
class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * The convention is plural -- and plural is assumed.
     *
     * Lowercase.
     *
     * @var string
     */
    public $table = "categories";
    /**
     * Which fields may be mass assigned
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'enabled'
    ];
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
        'title'          => 'trim|strip_tags|ucwords',
        'content'        => 'trim',
        'description'    => 'trim',
        'featured_image' => 'trim',
    ];

    /**
     * Sanitation rules for UPDATE
     *
     * @var array
     */
    public $sanitationRulesForUpdate = [
        'content'        => 'trim',
        'description'    => 'trim',
        'featured_image' => 'trim',
    ];


    // VALIDATION RULES PROPERTIES

    /**
     * Validation rules for Create (INSERT)
     *
     * @var array
     */
    public $validationRulesForCreate = [
        'title'       => 'required|min:4|unique:tags',
        'description' => 'min:4',
    ];

    /**
     * Validation rules for UPDATE
     *
     * @var array
     */
    public $validationRulesForUpdate = [
        'description' => 'min:4',
    ];


    ///////////////////////////////////////////////////////////////////
    //////////////        RELATIONSHIPS             ///////////////////
    ///////////////////////////////////////////////////////////////////

    /*
     * Many categories per single post
     *
     * @return Eloquent
     */
    public function post()
    {
        return $this->belongsToMany('Lasallesoftware\Quickanddirtyblog\Models\Post', 'post_category');
    }

    /*
     * Many tags per single post FOR VOYAGER?
     *
     *  Method name must be the model name, *not* the table name
     *
     * @return Eloquent
     */
    public function posts()
    {
        return $this->belongsToMany('Lasallesoftware\Quickanddirtyblog\Models\Post', 'post_category');
    }

    /*
     * A category can have one parent category
     *
     * @return Eloquent
     */
    public function parent()
    {
        return $this->hasOne('Lasallesoftware\Quickanddirtyblog\Models\Category', 'id', 'parent_id');
    }

    /*
     * A category can have multiple children categories
     *
     * @return Eloquent
     */
    public function children()
    {
        return $this->hasMany('Lasallesoftware\Quickanddirtyblog\Models\Category', 'parent_id', 'id');
    }

    ///////////////////////////////////////////////////////////////////
    //////////////        LOCAL QUERY SCOPES        ///////////////////
    ///////////////////////////////////////////////////////////////////
    /**
     * Scope a query to only include published tags.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('enabled', '=', 1);
    }


    ///////////////////////////////////////////////////////////////////
    //////////////        FOR VOYAGER ADMIN         ///////////////////
    ///////////////////////////////////////////////////////////////////
    public function save(array $options = [])
    {
        $this->created_by = Auth::user()->id;
        $this->updated_by = Auth::user()->id;

        parent::save();
    }
}