<?php
  include "config.php";

class Conn {

    var $user = _USER_;
    var $pass = _PASS_;
    var $host = _HOST_;
    var $db   = _DB_;

  	var $link = "";
    var $res = "";

  	function __construct(){
        $this->link = mysqli_connect($this->host,$this->user,$this->pass, $this->db);
  		if (!$this->link)
  		{
  			die("<h3>Error: could not connect to database</h3>");
  		}

      // Set
        mysqli_query($this->link, "SET NAMES 'utf8'");
        mysqli_query($this->link, 'SET character_set_connection=utf8');
        mysqli_query($this->link, 'SET character_set_client=utf8');
        mysqli_query($this->link, 'SET character_set_results=utf8');
  	}

    // Destruct 
    function __destruct(){
        @mysqli_close($this->link);
     }

     // Close connection
    function close() {
  		@mysqli_close($this->link);
  	}

    // Execute INSERT, DELETE, UPDATE
    function exec($query) {
      	return mysqli_query($this->link, $query);
    }

    // Execute SELECT and returns a array
    function query( $query ){
        $rows = array();
        if( $res = mysqli_query($this->link, $query) ){
            while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){
                $rows[] = $row;
            }
        }
        return $rows;
    }

    // Return the number of rows
    function numRows($res) {
        return mysqli_num_rows($res);
    }

    function getConn() {
        return $this->link;
    }


  }
 ?>
