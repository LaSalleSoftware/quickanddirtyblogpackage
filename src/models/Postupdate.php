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

/**
 * Class Postupdate
 * @package Lasallesoftware\Quickanddirtyblog\Models
 */
class Postupdate extends Model
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
    public $table = "postupdates";

    /**
     * Which fields may be mass assigned
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'excerpt', 'post_id', 'enabled', 'publish_on'
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
        'title'       => 'trim|strip_tags',
        'content'     => 'trim',
        'excerpt'     => 'trim|strip_tags',
    ];

    /**
     * Sanitation rules for UPDATE
     *
     * @var array
     */
    public $sanitationRulesForUpdate = [
        'title'       => 'trim|strip_tags',
        'content'     => 'trim',
        'excerpt'     => 'trim|strip_tags',
    ];


    // VALIDATION RULES PROPERTIES

    /**
     * Validation rules for Create (INSERT)
     *
     * @var array
     */
    public $validationRulesForCreate = [
        'title'       => 'required|min:4',
        'content'     => 'required|min:4',
    ];

    /**
     * Validation rules for UPDATE
     *
     * @var array
     */
    public $validationRulesForUpdate = [
        'title'       => 'required|min:4',
        'content'     => 'required|min:4',
    ];



    ///////////////////////////////////////////////////////////////////
    //////////////        RELATIONSHIPS             ///////////////////
    ///////////////////////////////////////////////////////////////////
    /*
     * One to one relationship with post table
     *
     * @return Eloquent
     */
    public function post()
    {
        return $this->belongsTo('Lasallecms\Lasallecmsapi\Models\Post');
    }
}