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

// Encountered problems with timestamp(). See https://github.com/laravel/framework/issues/3602


// Laravel classes
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTables
 */
class LookupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('lookup_workflow_status')) {

            Schema::create('lookup_workflow_status', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('title')->unique();
                $table->string('description');
                $table->boolean('enabled')->default(true);
                $table->timestamp('created_at');
                $table->integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->timestamp('updated_at')->nullable();
                $table->integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->timestamp('locked_at')->nullable();
                $table->integer('locked_by')->nullable()->unsigned();
                $table->foreign('locked_by')->references('id')->on('users');
            });
        }

        if (!Schema::hasTable('categories')) {

            Schema::create('categories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->integer('parent_id')->unsigned()->default(0);
                $table->string('title')->unique();
                $table->string('slug')->unique();
                $table->text('content')->nullable();
                $table->string('description')->nullable();
                $table->string('featured_image')->nullable();
                $table->boolean('enabled')->default(true);;
                $table->timestamp('created_at');
                $table->integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->timestamp('updated_at')->nullable();
                $table->integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->timestamp('locked_at')->nullable();
                $table->integer('locked_by')->nullable()->unsigned();
                $table->foreign('locked_by')->references('id')->on('users');
            });
        }

        // TAGS is a lookup table, although the table name is not prefixed with "lookup_"
        if (!Schema::hasTable('tags')) {

            Schema::create('tags', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id')->unsigned();
                $table->string('title')->unique();
                $table->string('description');
                $table->boolean('enabled')->default(true);;
                $table->timestamp('created_at');
                $table->integer('created_by')->unsigned();
                $table->foreign('created_by')->references('id')->on('users');
                $table->timestamp('updated_at')->nullable();
                $table->integer('updated_by')->unsigned();
                $table->foreign('updated_by')->references('id')->on('users');
                $table->timestamp('locked_at')->nullable();
                $table->integer('locked_by')->nullable()->unsigned();
                $table->foreign('locked_by')->references('id')->on('users');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Disable foreign key constraints or these DROPs will not work
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::table('categories', function($table){
            $table->dropIndex('categories_title_unique');
            $table->dropForeign('categories_created_by_foreign');
            $table->dropForeign('categories_updated_by_foreign');
            $table->dropForeign('categories_locked_by_foreign');
        });
        Schema::dropIfExists('categories');

        Schema::table('tags', function($table){
            $table->dropIndex('tags_title_unique');
            $table->dropForeign('tags_created_by_foreign');
            $table->dropForeign('tags_updated_by_foreign');
            $table->dropForeign('tags_locked_by_foreign');
        });
        Schema::dropIfExists('tags');

        Schema::table('lookup_workflow_status', function($table){
            $table->dropIndex('lookup_workflow_status_title_unique');
            $table->dropForeign('lookup_workflow_status_created_by_foreign');
            $table->dropForeign('lookup_workflow_status_updated_by_foreign');
            $table->dropForeign('lookup_workflow_status_locked_by_foreign');
        });
        Schema::dropIfExists('lookup_workflow_status');

        // Enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
