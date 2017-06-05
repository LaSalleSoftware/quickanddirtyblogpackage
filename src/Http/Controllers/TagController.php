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
use Lasallesoftware\Quickanddirtyblog\Models\Tag;

// Third party classes
use Carbon\Carbon;


/**
 * Class TagController
 * @package Lasallesoftware\Quickanddirtyblog\Http\Controllers
 */
class TagController extends Controller
{
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model   = $model;
    }

    public function DisplayPostsByTag($title)
    {

        // https://laravel.com/docs/5.4/eloquent-relationships#constraining-eager-loads

        $now = Carbon::now();

        $tags = $this->model
            ->published()
            ->where('title', '=', $title)
            ->with(['posts' => function ($query) use ($now) {
                $query->where('enabled', '=', 1);
                $query->where('publish_on', '<=', $now);
            }])
            ->first();

        if (count($tags->posts) == 0) {
            return redirect()->route('displayallposts');
        }

        $pageTitle          = "Blog Posts With The " . $tags->title . " Tag | " . config('app.name');
        $articleTitle       = 'Blog Posts With The "' . $tags->title . '" Tag';
        $articleDescription = "Blog Posts With The " . $tags->title . " Tag";
        $socialtagurl       = env('APP_URL') . '/tag/' . $title;
        $header_image       = config('socialtags.defaultblogimage');

        return view('blog.list_posts')->with([
            'skip_tags_social_media' => true,
            'pageTitle'              => $pageTitle,
            'articleTitle'           => $articleTitle,
            'articleDescription'     => $articleDescription,
            'socialtagurl'           => $socialtagurl,
            'header_image'           => $header_image,
            'posts'                  => $tags->posts->sortByDesc('updated_at'),
        ]);
    }
}