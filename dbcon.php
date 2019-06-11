<?php
class Dbconfig
{
	public $conn;

	public function __construct(){
		define("HOST",'localhost');
		define("ROOT",'root');
		define("PASS",'');
		define("DATABASE",'phptestcode');
		$this->conn  = mysqli_connect(HOST, ROOT, PASS, DATABASE);
	}	
	
	public function fetchAllRows($query){
		$queryval = mysqli_query($this->conn,$query);
		while ($record = mysqli_fetch_object($queryval)) {
         $result[] = $record;
		}
		return $result;
	}
	
	public function num_of_rows($query){
		$result = mysqli_query($this->conn,$query);
		return mysqli_num_rows($result);
	}
	public function query_run($query){
		$result=mysqli_query($this->conn,$query);
		return mysqli_affected_rows($result);
	}
}
?>