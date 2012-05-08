<?php

class Composeur_Cli_Task
{
	private $start_dir;
	public function __construct()
	{
		$this->start_dir = getcwd();
		chdir(path('base'));
	}
	public function __destruct()
	{
		chdir($this->start_dir);
	}

	public function run($args)
	{
		call_user_func_array(array($this, 'help'), array($args));
	}

	public function __call($name, $args)
	{
		$args = $args[0];
		$args = count($args) > 0 ? ' ' . implode(' ', $args) : '';
		$output = $this->exec($name . $args);
		echo $output;
	}

	public function test()
	{
		$output = $this->exec('help');
		if (strpos($output, 'Composer version') === 0)
		{
			echo PHP_EOL . "Composer has been installed successfully!" . PHP_EOL;
			return true;
		}

		echo PHP_EOL . "Composer doesn't appear to be installed correctly." . PHP_EOL;
		return false;
	}

	public function has_lock()
	{
		return File::exists($this->dir() . 'composer.lock');
	}

	protected function exec($cmd = '')
	{
		$cmd = ($cmd === 'help') ? '' : $cmd;

		if ((strpos($cmd, 'install') === 0) || (strpos($cmd, 'update') === 0))
		{
			$this->writeConfig();
		}

		exec('php ' . $this->path() . ' ' . $cmd . ' 2>&1', $output);
		return implode(PHP_EOL, $output);
	}

	protected function writeConfig()
	{
		$config = Config::get('composeur');
		if (! empty($config))
		{
			unset($config['auto_update']);
			File::put($this->dir() . 'composer.json', json_encode($config));
		}
	}

	protected function dir()
	{
		return path('base');
	}

	protected function file()
	{
		return 'composer.phar';
	}

	protected function path()
	{
		return $this->dir() . $this->file();
	}
}