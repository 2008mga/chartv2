<?php namespace App;

use App\Helpers\SingleTrait;

class Database {
	use SingleTrait;

	protected $connect;
	protected $config;
	protected $queryRaw;
	protected $query;
	protected $results;
	protected $migrations;

	public function __construct()
	{
		$this->refreshConfigs();

		try {
			$this->connect();
		} catch (\Exception $e) {
			die($e->getMessage());
		}
	}

	protected function connect() 
	{
		$this->connect = new \mysqli(
			$this->getConfVal('host'), 
			$this->getConfVal('user'), 
			$this->getConfVal('password'), 
			$this->getConfVal('table')
		);

		if (!$this->connect) {
			throw new \Exception("Error connect to database", 1);
		}
	}

	protected function refreshConfigs()
	{
		$this->config = require_once CONFIG_DIR . '/' . 'db.php';
	}

	protected function getConfVal($key)
	{
		if (!key_exists($key, $this->config)) {
			return false;
		}

		return $this->config[$key];
	}

	public function query($sql)
	{
		$this->queryRaw = $sql;
		$this->query = $this->connect->query($sql);
		
		return $this;
	}

	public function fetch()
	{
		foreach ($this->query as $row) 
		{
			$this->results[] = $row;
		}
		
		return $this;
	}

	public function get()
	{
		return $this->results;
	}

	public function migrate($migrations)
	{
		$this->migrations = $migrations;

		foreach ($this->migrations as $migration) {
			# run migrations
			$this->query(require_once $migration);
		}
	}
}