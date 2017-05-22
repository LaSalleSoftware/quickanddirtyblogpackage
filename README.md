# Quick and Dirty Blog Package

My very quick and dirty blog package, based on LaSalle Software version 1.

My LaSalle Software version 1 needs to be updated from Laravel 5.1LTS to v5.4. I will rewrite my Software along with this update. 

I have almost half a dozen of my own websites to do, including consolidating three of my sites into one flagship site under the LaSalleSoftware.ca domain. The plan was to write my Software first, and then base my sites on my re-written Software. Not to be! 
 
 My greatest need right now is blogging. So I am creating this package so I can get my sites up-and-running first. 
 
 
 # Caveat
 
 When I say "quick and dirty", it's no joke that I am intending this package to be disposable. It is meant to get me "over the hump" en route to using LaSalle Software v2 for my sites. So, yes, this is feature incomplete. You will rant and rave at the lack of tests.  I am taking it easy with setting up GitHub for this package. I might use this package to poke around the new GitHub features, though [(Introducing GitHub Marketplace and more tools to customize your workflow)](https://github.com/blog/2359-introducing-github-marketplace-and-more-tools-to-customize-your-workflow).
 
 
 # A Real Composer Installable Package Based on the Laravel Framework
 
 OTOH, this is a real package. 
  * based on the latest Laravel Framework version -- v5.4
  * real package structure
  * composer installable, listed on Packagist
  
 
 # INSTALLATION
 
## Service Provider

In config/app.php:
```
Lasallesoftware\Quickanddirtyblog\QuickanddirtyblogServiceProvider::class,
```

## Facade Alias

* none


## Dependencies
* none


## Special Step To Set-up The Seeding

There is a special step to do. I placed this package's seed file within the namespace instead of its usual spot within the "database" folder off the package's root folder. 

In your app's "database\seeds\DatabaseSeeder.php" file, change your run() method to:
```
public function run()
{
    $now = Carbon::now();

    User::create([
        'name'       => 'Bob Bloom',
        'email'      => 'bob.bloom@lasallesoftware.ca',
        'password'   => bcrypt('password'),
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    $this->call(Lasallesoftware\Quickanddirtyblog\Seeds\LookupTablesSeeder::class);
}
```

## composer.json:

Two things:

(1) Set up your classmap to include your "seeds" subfolder by adding the line "database/seeds" to the autoload section of composer.json:
```
"autoload": {
    "classmap": [
        "database",
        "database/seeds"
    ],
    "psr-4": {
        "App\\": "app/"
    }
},
```

(2) Add this package to the require section:

```
{
    "require": {
        "lasallesoftware/quickanddirtyblog": "1.*",
    }
}
```

Now, run:
```
composer update
```


## Publish the Package's Config

With Artisan:
```
php artisan vendor:publish
```

## Migration

With Artisan:
```
php artisan migrate
```

## Seeding

With Artisan:
```
php artisan db:seed
```


# CONTRIBUTIONS

If the mood strikes to contribute, you should email me first.


# FEEDBACK

You are actually using this package? Wow. Report security issues or just general feedback to bob.bloom@lasallesoftware.ca.
