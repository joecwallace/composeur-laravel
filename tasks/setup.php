<?php

require 'cli.php';

class Composer_Setup_Task extends Composer_Cli_Task
{
	public function run($args = array())
	{
		exec('curl -s http://getcomposer.org/installer | php -- --install-dir ' . $this->dir(), $output);
		echo implode(PHP_EOL, $output);

		$this->test();
	}

	public function auto_update()
	{
		Schema::create('composer_bundle', function($table)
		{
			$table->string('version', 32);
		});
	}
}