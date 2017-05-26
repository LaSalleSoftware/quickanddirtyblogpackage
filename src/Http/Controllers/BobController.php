<?php

namespace Lasallesoftware\Quickanddirtyblog\Http\Controllers;

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


use Illuminate\Database\Eloquent\Factory as Factory;


/**
 * Class BobController
 * @package Lasallesoftware\Quickanddirtyblog\Http\Controllers
 */
class BobController extends Controller
{
    protected $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function mess()
    {
        // MUST have the leading "\"
        $posts = factory(\Lasallesoftware\Quickanddirtyblog\Models\Post::class, 3)->make();
        //$posts = factory(\Lasallesoftware\Quickanddirtyblog\Models\Post::class, 3)->create();

        foreach ($posts as $post) {
            echo "<br>title = ".$post->title;
        }

        echo "<pre>";
        //print_r($posts);
        echo "</pre>";


        return "<br>Finally got it to work, eh!!!!!";

    }
}