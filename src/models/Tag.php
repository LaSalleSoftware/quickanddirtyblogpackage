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
 * Class Tag
 * @package Lasallesoftware\Quickanddirtyblog\Models
 */
class Tag extends Model
{
    ///////////////////////////////////////////////////////////////////
    //////////////          PROPERTIES              ///////////////////
    ///////////////////////////////////////////////////////////////////

    /**
     * The database table used by the model.
     *
     * @var string
     */
    public $table = 'tags';

    /**
     * Which fields may be mass assigned
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


    ///////////////////////////////////////////////////////////////////
    //////////////        RELATIONSHIPS             ///////////////////
    ///////////////////////////////////////////////////////////////////
    /*
     * Many tags per single post
     *
     *  Method name must be the model name, *not* the table name
     *
     * @return Eloquent
     */
    public function post()
    {
        return $this->hasMany('Lasallesoftware\Quickanddirtyblog\Models\Post', 'post_tag');
    }

    /*
     * Many tags per single post  FOR VOYAGER ADMIN
     *
     *  Method name must be the model name, *not* the table name
     *
     * @return Eloquent
     */
    public function posts()
    {
        return $this->belongsToMany('Lasallesoftware\Quickanddirtyblog\Models\Post', 'post_tag');
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