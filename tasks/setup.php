<?php

require 'cli.php';

class Composeur_Setup_Task extends Composeur_Cli_Task
{
	public function run($args = array())
	{
		exec('curl -s http://getcomposer.org/installer | php -- --install-dir ' . $this->dir(), $output);
		echo implode(PHP_EOL, $output);

		$this->test();
	}
}