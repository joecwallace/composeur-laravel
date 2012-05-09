<?php

$config = Config::get('composeur');

$my_bundle = function()
{
	if (! Request::cli())
		return false;

	foreach ($_SERVER['argv'] as $key => $val)
	{
		if (strpos($val, 'composeur::') === 0)
		{
			echo 'my bundle';
			return true;
		}
	}
	return false;
};

if (! $my_bundle() && isset($config['auto_update']) && $config['auto_update'])
{
	require dirname(__FILE__) . '/tasks/setup.php';

	$cli = new Composeur_Setup_Task;

	if (! $cli->test())
		$cli->run();

	if (! $cli->has_lock())
		$cli->install(array());

	if (File::modified($cli->dir() . 'composer.json') < File::modified(path('app') . 'config/composeur.php'))
		$cli->update(array());

	ob_clean();
}

$composer_autoload = path('base') . 'vendor/autoload.php';
if (File::exists($composer_autoload))
{
	require $composer_autoload;
}