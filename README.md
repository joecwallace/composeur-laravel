## A [Composer](http://getcomposer.org/) bundle for [Laravel](http://laravel.com/)

Not sure what's going on here? Here are the [Laravel docs](http://laravel.com/docs), and here are the [Composer docs](http://getcomposer.org/doc/).

I can't take much credit at all for what's going on here. Praise and adoration go to the [Laravel](http://laravel.com/) and [Composer](http://getcomposer.org/) people.

### Quick Start

1. Install the bundle

        php artisan bundle:install composeur

1. Add composeur to ```bundles.php```

        return array(
            'composeur' => array(
            	'auto' => true,
            ),
        );

1. Create ```application/config/composeur.php```

        return array(
        	'auto_update' => true, /* <== You'll need that */
        	'require' => array(
        		/* Composer require key styled as an associative array */
        		/* http://getcomposer.org/doc/01-basic-usage.md#the-require-key */
        	),
        );

1. Get out there and use your Composer packages

##### Gotcha: ```auto_update``` requires write permissions in the ```{base}``` and ```{base}/vendor``` directories

##### Note:   The first page load after configuration changes will take a while

### A Partial Example

With this ```application/config/composeur.php```

    return array(
        'auto_update' => true,
        'require' => array(
            'monolog/monolog' => '1.0.*',
        ),
    );

Monolog will be available anywhere in your Laravel application, so you could say

    Route::get('/', function()
    {
        $log = new Monolog\Logger('test');
        $log->pushHandler(new Monolog\Handler\StreamHandler(path('storage') . 'logs/mono.log', Monolog\Logger::WARNING));
        $log->addWarning('Hey, look! A visitor!');

        return View::make('home.index');
    });

### Get Started in a *Slightly* More Advanced Way

1. Install the bundle

        php artisan bundle:install composeur

1. Add composeur to ```bundles.php```

        return array(
            'composeur' => array(
            	'auto' => true,
            ),
        );

1. Set up composeur (installs Composer in the ```{base}``` dir)

        php artisan composeur::setup

1. Create ```application/config/composeur.php``` (or don't, see below)

        return array(
        	'auto_update' => false, /* <== This can be omitted */
        	'require' => array(
        		/* Composer require key styled as an associative array */
        		/* http://getcomposer.org/doc/01-basic-usage.md#the-require-key */
        	),
        );

1. Now use the composeur bundle's Cli task

        php artisan composeur::cli:install

    or

        php artisan composeur::cli:update

    etc...

##### Note: With ```auto_update``` set to false, you are responsible for installing and updating your Composer packages.

### More thoughts

#### Running ```php artisan composeur::cli:update``` versus ```php composer.phar update```

It's not necessary to use the composeur bundle's Cli task to run Composer. Running ```php artisan composeur::setup``` installs composer.phar in the ```{base}``` directory, so from there you can simply run ```php composer.phar [command]```.

#### Not adding ```application/config/composeur.php```

If you choose, you need not create ```application/config/composeur.php```. As mentioned above, after the composeur bundle is setup, you can use it from the ```{base}``` directory, so just create your own ```composer.json``` file there and get going. **Warning:** if you create your own ```composer.json``` and later create ```application/config/composeur.php```, your ```composer.json``` might get eaten.

#### Autoloaders and namespace conflicts

This bundle adds Composer's autoloader to PHP's collection of autoloaders. It's added after Laravel's, so Laravel should have the first shot at resolving classes and namespaces. I suppose this means there is *some* chance of namespaces being resolved by Laravel when you want them to be resolved by Composer, but I guess you can figure that out.

### License

MIT license - [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
