## A [Composer](http://getcomposer.org/) bundle for [Laravel](http://laravel.com/)

### Quick Start

1. Install the bundle

        php artisan bundle:install composer

1. Add composer to ```bundles.php```

        return array(
            'composer' => array(
            	'auto' => true,
            ),
        );

1. Set up composer's "auto-update" capability ([Set up your database first](http://laravel.com/docs/database/config))

        php artisan composer::setup:auto_update

1. Create ```application/config/composer.php```

        return array(
        	'auto_update' => true, /* <== You'll need that */
        	'require' => array(
        		/* http://getcomposer.org/doc/01-basic-usage.md#the-require-key */
        	),
        );

1. Get out there and use your Composer packages

##### Gotcha: ```auto_update``` requires write permissions in the base and base/vendor directories
##### Note:   The first page load after configuration changes will take a while

### A Partial Example

With this ```application/config/composer.php```

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

1. Coming soon...