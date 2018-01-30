<?php namespace App;

use App\Database;
use App\Response;

class App extends Response {

	protected $db;
	protected $migrations;

	public function __construct(array $migrations)
	{
		$this->db = Database::boot();
		$this->migrations = $migrations;
	}

	public function getData()
	{
		$data = $this->db
					 ->query('SELECT date1, temp, hum from esp1')
					 ->get();

		echo $this->json_response($data,200);
	}

	public function migrate()
	{
		$this->db->migrate($this->migrations);
	}
}