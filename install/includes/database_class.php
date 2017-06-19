<?php

class Database {

	function create_database($data)
	{
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

		if(mysqli_connect_errno())
			return false;

		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);
		$mysqli->close();

		return true;
	}

	function create_tables($data)
	{

		$this->run_sql_file($data);

		return true;
	}

	private function run_sql_file($data){
		$location = 'assets/install.sql';
		$commands = file_get_contents($location);


		$lines = explode("\n",$commands);
		$commands = '';
		foreach($lines as $line){
			$line = trim($line);
			if( $line && !$this->startsWith($line,'--') ){
				$commands .= $line . "\n";
			}
		}

		$commands = explode(";", $commands);


		$total = $success = 0;
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);
		if(mysqli_connect_errno())
                        return false;

		foreach($commands as $command){

			if(trim($command)){
				$success += (@mysqli_query($mysqli, $command)==false ? 0 : 1);
				$total += 1;
			}
		}
		$mysqli->close();

		return array(
				"success" => $success,
				"total" => $total
			    );
	}
	
	private function startsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}
}
