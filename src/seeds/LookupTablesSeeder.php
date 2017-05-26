<?php


namespace Lasallesoftware\Quickanddirtyblog\Seeds;

// Laravel classes
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// Package's classes
use Lasallesoftware\Quickanddirtyblog\Models\Category;
use Lasallesoftware\Quickanddirtyblog\Models\Lookup_workflow_status;

// Third party classes
use Carbon\Carbon;

/**
 * Class LookupTablesSeeder
 * @package Lasallesoftware\Quickanddirtyblog\Seeds
 */
class LookupTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $now = Carbon::now();

        ////////////////////////////////////////////////////
        //                Category                        //
        ////////////////////////////////////////////////////
        Category::create([
            'parent_id'      => 0,
            'title'          => 'Blog',
            'slug'           => 'blog',
            'content'        => '',
            'description'    => 'The main blog category',
            'featured_image' => '',
            'enabled'        => 1,
            'created_at'     => $now,
            'created_by'     => 1,
            'updated_at'     => $now,
            'updated_by'     => 1,
        ]);

        ////////////////////////////////////////////////////
        //           Lookup_workflow_status               //
        ////////////////////////////////////////////////////
        Lookup_workflow_status::create([
            'title'       => 'In Progress',
            'description' => 'Currently being edited.',
            'enabled'     => 1,
            'created_at'  => $now,
            'created_by'  => 1,
            'updated_at'  => $now,
            'updated_by'  => 1,
        ]);

        Lookup_workflow_status::create([
            'title'       => 'Awaiting Approval',
            'description' => 'Waiting for approval of edits.',
            'enabled'     => 1,
            'created_at'  => $now,
            'created_by'  => 1,
            'updated_at'  => $now,
            'updated_by'  => 1,
        ]);

        Lookup_workflow_status::create([
            'title'       => 'Approved',
            'description' => 'Edits are approved.',
            'enabled'     => 1,
            'created_at'  => $now,
            'created_by'  => 1,
            'updated_at'  => $now,
            'updated_by'  => 1,
        ]);

        Lookup_workflow_status::create([
            'title'       => 'Published',
            'description' => 'Published.',
            'enabled'     => 1,
            'created_at'  => $now,
            'created_by'  => 1,
            'updated_at'  => $now,
            'updated_by'  => 1,
        ]);

        Lookup_workflow_status::create([
            'title'       => 'Fire the Publish Event',
            'description' => 'Fire the publish event.',
            'enabled'     => 1,
            'created_at'  => $now,
            'created_by'  => 1,
            'updated_at'  => $now,
            'updated_by'  => 1,
        ]);

        Model::reguard();
    }
}