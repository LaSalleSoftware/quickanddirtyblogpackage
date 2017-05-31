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

// Laravel classes
use Illuminate\Database\Eloquent\Factory as Factory;

// LaSalle Software
use Lasallesoftware\Quickanddirtyblog\Models\Post;



use Carbon\Carbon;


/**
 * Class BobController
 * @package Lasallesoftware\Quickanddirtyblog\Http\Controllers
 */
class PostController extends Controller
{
    protected $factory;

    protected $model;

    public function __construct(Factory $factory, Post $model)
    {
        $this->factory = $factory;
        $this->model   = $model;
    }

    public function bob()
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

    public function DisplayAllPosts()
    {
        // Sticky posts
        $posts_sticky = $this->model
            ->published()
            ->sticky()
            ->with('tags')
            ->with('categories')
            ->get()
            ->sortByDesc('updated_at')
        ;

        // Non-sticky posts
        $posts_notsticky = $this->model
            ->published()
            ->notsticky()
            ->with('tags')
            ->with('categories')
            ->get()
            ->sortByDesc('updated_at')
        ;


        // Merge the two collections
        $posts = $posts_sticky->merge($posts_notsticky);

        if (count($posts) == 0) {
            return "NO POSTS!";
            //return redirect()->route('home');
        }

        foreach ($posts as $post) {

            echo "<br>======<br>title = ".$post->title . " (".$post->slug.")";

            echo "<h4>tags:</h4>";
            foreach ($post->tags as $tag) {
                echo $tag->title . "<br>";
            }

            echo "<h4>categories:</h4>";
            foreach ($post->categories as $category) {
                echo $category->title . "<br>";
            }
        }
    }

    public function DisplaySinglePost($slug) {
        $post = $this->model
            ->published()
            ->where('slug', '=', $slug)
            ->with('tags')
            ->with('categories')
            ->first()
            ;

        if (count($post) == 0) {
            return redirect()->route('displayallposts');
        }


        echo "<br>count = ".count($post);
        echo "<br>title = ".$post->title;
    }
}