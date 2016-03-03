<?php
	#include("db.php");
	function tampil(){
		require "db.php";
		#require_once "tampil.php";
		global $conn;
		//Print Detail Interface
		$query = "SELECT *
				FROM  data_perangkat";
		//$query = "SELECT *
		//			FROM  data_interface";
		//

		//Query Database
		$hasil = $conn->query($query);
		if ($hasil->num_rows > 0) {
			while($row = $hasil->fetch_array()) {
			  $data[]=$row;
			}
			return $data;
		} else {
	    	return "Tidak Ada Data";
		}			
	}
?>

