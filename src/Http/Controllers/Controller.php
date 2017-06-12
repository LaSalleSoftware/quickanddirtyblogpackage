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
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// LaSalle Software
use Lasallesoftware\Quickanddirtyblog\Models\Post;
use App\User;

/**
 * Class Controller
 * @package Lasallesoftware\Quickanddirtyblog
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function formatDate($post)
    {
        if ((!empty($post->updated_at)) || ($post->updated_at == "0000-00-00 00:00:00")) {

            $html = "Updated " . $post->updated_at->toFormattedDateString();

            if ($post->created_at <> $post->updated_at) {
                $html .= " (Originally Published " . $post->created_at->toFormattedDateString()  . ")";
            }

            return $html;
        }

        return "Published " . $post->created_at->toFormattedDateString();
    }

    public function authorName($post)
    {
        if (!empty($post->updated_by)) {
            return User::find($post->updated_by)->name;
        }

        return User::find($post->created_by)->name;
    }

    public function formatCategories($post)
    {
        if (count($post->categories) == 0) {
            return "This Post Has No Categories";
        }

        if (count($post->categories) == 1) {
            $html = "Category: ";
        } else {
            $html = "Categories: ";
        }

        $i    = 1;
        foreach ($post->categories as $category) {
            $html .= '<a href="/category/'.$category->slug.'">'.$category->title.'</a> ';
            $html .= $this->listOfLinksDelimiter($i, count($post->categories));
            $i++;
        }

        return $html;
    }

    public function formatTags($post)
    {
        if (count($post->tags) == 0) {
            return "This Post Has No Tags";
        }

        if (count($post->tags) == 1) {
            $html = "Tag: ";
        } else {
            $html = "Tags: ";
        }
        $i    = 1;
        foreach ($post->tags as $tag) {
            $html .= '<a href="/tag/'.$tag->title.'">'.$tag->title.'</a> ';
            $html .= $this->listOfLinksDelimiter($i, count($post->tags));
            $i++;
        }

        return $html;
    }

    public function listOfLinksDelimiter($counter, $number_of_items)
    {
        // this is the last link in the list, so there is no delimiter to return
        if ($counter == $number_of_items) {
            return "";
        }

        return " " . $this->delimiter . " ";
    }


    public function formatPreviousPost($updated_at)
    {
        $previous = $this->model
            ->published()
            ->notsticky()
            ->where('updated_at', '<', $updated_at)
            ->orderBy('updated_at', 'desc')
            ->first()
        ;

        if (count($previous) == 0) {
            return false;
        }

        return 'Previous Post: <a href="'.$previous->canonical_url.'">'.$previous->title.'</a>';
    }

    public function formatNextPost($updated_at)
    {
        $next = $this->model
            ->published()
            ->notsticky()
            ->where('updated_at', '>', $updated_at)
            ->orderBy('updated_at', 'asc')
            ->first()
        ;

        if (count($next) == 0) {
            return false;
        }

        return 'Next Post: <a href="'.$next->canonical_url.'">'.$next->title.'</a>';
    }
}
