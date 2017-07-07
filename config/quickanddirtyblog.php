<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Suppress {slug} route
    |--------------------------------------------------------------------------
    |
    | The Route::get('{slug}', 'Lasallesoftware\Quickanddirtyblog\Http\Controllers\PostController@DisplaySinglePost');
    | sometimes has to be at the end of the app's route list. Otherwise, other legitimate
    | routes will not be evaluated. Suppress it here -- and remember to add it to your app's routes!
    */

    'suppress_frontend_slug_route' => false,

];
