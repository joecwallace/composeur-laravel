<?php

$config = Config::get('composeur');

$my_bundle = Request::cli() && function()
{
	foreach ($_SERVER['argv'] as $key => $val)
	{
		if (strpos($val, 'composeur::') === 0)
		{
			return true;
		}
	}
	return false;
};

if (! $my_bundle && isset($config['auto_update']) && $config['auto_update'])
{
	require dirname(__FILE__) . '/tasks/setup.php';
	$cli = new Composeur_Setup_Task;
	if (! $cli->test())
		$cli->run();
	if (! $cli->has_lock())
		$cli->install(array());

	$row = DB::table('composeur_bundle')->first();
	if (! $row || $row->version != md5(json_encode($config)))
	{
		$version = md5(json_encode($config));

		$cli->update(array());

		if (! $row)
			DB::table('composeur_bundle')->insert(compact('version'));
		else
			DB::table('composeur_bundle')->update(compact('version'));
	}

	ob_clean();
}

$composer_autoload = path('base') . 'vendor/autoload.php';
if (File::exists($composer_autoload))
{
	require $composer_autoload;
}