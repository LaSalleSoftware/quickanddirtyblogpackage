<?php

namespace Lasallesoftware\Quickanddirtyblog\Viewcomposers;

use Lasallesoftware\Quickanddirtyblog\Models\Post;
use Illuminate\View\View;

class BlogFooterComposer
{
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function compose(View $view)
    {
        $blogfooter_include_sticky_posts      = config('socialtags.blogfooter_include_sticky_posts');
        $blogfooter_number_of_posts_in_footer = config('socialtags.blogfooter_number_of_posts_in_footer');

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
            ->take($blogfooter_number_of_posts_in_footer)
            ->get()
        ;

        if ($blogfooter_include_sticky_posts) {
            // Merge the two collections
            $posts = $posts_sticky->merge($posts_notsticky);
        } else {
            $posts = $posts_notsticky;
        }

        $request = request();

        if ($request->path() == "blog/all") {
            $posts = [];
        }

        $view->with('postsinfooter', $posts);
    }
}