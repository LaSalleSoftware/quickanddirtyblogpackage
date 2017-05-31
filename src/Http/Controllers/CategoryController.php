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

// LaSalle Software
use Lasallesoftware\Quickanddirtyblog\Models\Category;

/**
 * Class CategoryController
 * @package Lasallesoftware\Quickanddirtyblog\Http\Controllers
 */
class CategoryController extends Controller
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model   = $model;
    }

    public function DisplayPostsByCategory($slug) {

        $categories = $this->model
            ->published()
            ->where('slug', '=', $slug)
            ->with('posts')
            ->get()
            ->sortBy('title')
        ;

        if (count($categories) == 0) {
            return "NO CATEGORIES!";
            //return redirect()->route('home');
        }

        foreach ($categories as $category) {

            echo "<h1>Category: ".$category->title."</h1>";

            foreach ($category->posts as $post) {
                echo "<br>post title = ".$post->title;
            }
        }
    }
}