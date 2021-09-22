<?php
class Db
{

    private $dbhost = "localhost";
    private $dbuser = "user1";
    private $dbport = "3306";
    private $dbpass = "r00tme";
    private $dbname = "icinga2";

    public function connect()
    {

        $mysql_connect_str = "mysql:host=$this->dbhost;port=$this->dbport;dbname=$this->dbname";
        $dbConncetion = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);

        return $dbConncetion;
    }


    
    public function connect2()
    {
        $dbhost2 = "10.140.5.70";
        $dbuser2 = "root";
        $dbport2 = "3306";
        $dbpass2 = "rootme";
        $dbname2 = "voip";

        $mysql_connect_str2 = "mysql:host=$this->dbhost2;port=this->$dbport2;dbname=this->$dbname2";
	//$conn = new mysqli($dbhost2,$dbuser2,$dbpass2);
	// Check connectio        
	$dbConncetion2 = new PDO($mysql_connect_str2, $dbuser2, $dbpass2);

	return $dbConnection2;
    }
}
