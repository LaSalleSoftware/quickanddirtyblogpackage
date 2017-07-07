<?php


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


// Posts by tag
Route::get('tag/{title}', 'Lasallesoftware\Quickanddirtyblog\Http\Controllers\TagController@DisplayPostsByTag');

// Posts by category
Route::get('/category/{slug}', 'Lasallesoftware\Quickanddirtyblog\Http\Controllers\CategoryController@DisplayPostsByCategory');

// All posts
Route::get('/blog/all', 'Lasallesoftware\Quickanddirtyblog\Http\Controllers\PostController@DisplayAllPosts')->name('displayallposts');

// Single post
// This route should be the last non-admin route evaluated
if (!Request::is('admin'))
{
    if (!config('quickanddirtyblog.suppress_frontend_slug_route')) {
         Route::get('{slug}', 'Lasallesoftware\Quickanddirtyblog\Http\Controllers\PostController@DisplaySinglePost');
    }
}


