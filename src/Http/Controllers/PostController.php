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

// Third party classes
use Carbon\Carbon;


/**
 * Class BobController
 * @package Lasallesoftware\Quickanddirtyblog\Http\Controllers
 */
class PostController extends Controller
{
    protected $factory;

    protected $model;

    public $delimiter = "|";


    public function __construct(Factory $factory, Post $model)
    {
        $this->factory = $factory;
        $this->model   = $model;
    }

    public function DisplayAllPosts()
    {
        // Sticky posts
        $posts_sticky = $this->model
            ->published()
            ->sticky()
            ->with('tags')
            ->with('categories')
            ->orderBy('updated_at', 'desc')
            ->get()
        ;

        // Non-sticky posts
        $posts_notsticky = $this->model
            ->published()
            ->notsticky()
            ->with('tags')
            ->with('categories')
            ->orderBy('updated_at', 'desc')
            ->get()
        ;


        // Merge the two collections
        $posts = $posts_sticky->merge($posts_notsticky);

        if (count($posts) == 0) {
            return "NO POSTS!";
            //return redirect()->route('home');
        }

        $pageTitle          = "Blog Posts | " .config('app.name');
        $articleTitle       = "Blog Posts";
        $articleDescription = "Blog Posts";
        $socialtagurl       = env('APP_URL') . '/blog/all';
        $header_image       = config('socialtags.defaultblogimage');

        return view('blog.list_posts')->with([
            'skip_tags_social_media' => true,
            'pageTitle'              => $pageTitle,
            'articleTitle'           => $articleTitle,
            'articleDescription'     => $articleDescription,
            'socialtagurl'           => $socialtagurl,
            'header_image'           => $header_image,
            'posts'                  => $posts,
        ]);
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

        $pageTitle          = $post->title . " | " .config('app.name');
        $articleTitle       = $post->title;
        $articleDescription = $post->excerpt;
        $socialtagurl       = $post->canonical_url;
        $socialtagimage     = env('APP_URL') . '/storage/' . $post->featured_image;
        $socialtagdatetime  = date('Y-m-d H:i:s');

        $post_title         = $post->title;
        $post_content       = $post->content;
        $post_date          = $this->formatDate($post);
        $post_author        = $this->authorName($post);
        $post_categories    = $this->formatCategories($post);
        $post_tags          = $this->formatTags($post);
        $post_previous      = $this->formatPreviousPost($post->updated_at);
        $post_next          = $this->formatNextPost($post->updated_at);


        return view('blog.single_post')->with([
                'pageTitle'              => $pageTitle,
                'articleTitle'           => $articleTitle,
                'articleDescription'     => $articleDescription,
                'socialtagurl'           => $socialtagurl,
                'socialtagimage'         => $socialtagimage,
                'socialtagdatetime'      => $socialtagdatetime,

                //'skip_tags_social_media' => true,
                'post_title'             => $post_title,
                'post_content'           => $post_content,
                'post_date'              => $post_date,
                'post_author'            => $post_author,
                'post_categories'        => $post_categories,
                'post_tags'              => $post_tags,
                'featured_image'         => $socialtagimage,

                'post_previous'          => $post_previous,
                'post_next'              => $post_next,
        ]);
    }
}