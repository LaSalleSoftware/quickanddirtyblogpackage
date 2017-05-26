<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// https://github.com/fzaninotto/Faker


use Carbon\Carbon;


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Lasallesoftware\Quickanddirtyblog\Models\Post::class, function (Faker\Generator $faker) {

    // cannot get the properties of the date object, so using reflection
    // https://stackoverflow.com/questions/14084222/why-cant-i-access-datetime-date-in-phps-datetime-class-is-it-a-bug
    $dateTimeBetween = $faker->dateTimeBetween('+0 days', '+3 month', $timezone = date_default_timezone_get());
    $o               = new ReflectionObject($dateTimeBetween);
    $p               = $o->getProperty('date');
    $publish_on      = substr($p->getValue($dateTimeBetween), 0, 10);


    $dateTimeNow     = Carbon::now();;
    $o               = new ReflectionObject($dateTimeNow);
    $p               = $o->getProperty('date');
    $now             = $p->getValue($dateTimeNow);

    return [
        'id'                        => $faker->unique()->randomDigit,
        'lookup_workflow_status_id' => 1,
        'title'                     => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'slug'                      => $faker->unique()->slug,
        'content'                   => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'excerpt'                   => $faker->text($maxNbChars = 200),
        'meta_description'          => $faker->text($maxNbChars = 200),
        'canonical_url'             => $faker->url,
        'featured_image'            => $faker->word,
        'enabled'                   => $faker->boolean($chanceOfGettingTrue = 60),
        'postupdate'                => false,
        'publish_on'                => $publish_on,
        'created_at'                => NULL,  // $now is not working
        'created_by'                => 1,
        'updated_at'                => NULL,   // $now is not working
        'updated_by'                => 1,
        'locked_at'                 => NULL,
        'locked_by'                 => NULL,
    ];
});

/*
$posts = factory(Lasallesoftware\Quickanddirtyblog\Models\Post::class, 10)->make();
echo "<pre>";
foreach ($posts as $pos) {
    print_r($posts);
}

dd("register this one FACTORYEOIRU!!");
*/