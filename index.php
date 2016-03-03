<?php
	echo "Network Management System <br><br>";
	require "detail.php";
	function tampil(){
		require "function/db.php";
		
		$query = "SELECT *
				FROM  data_perangkat";

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

	function ping($host){
		exec("ping -c 2 " . $host, $output, $result);
		if ($result == 0)
			return "Up";
		else
			return "Down";
	}
?>

<html>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Nama Device</th>
			<th>IP</th>
			<th>Status</th>
			<th>Aksi</th>
		</tr>		
			<?php
				$data = tampil();
				$i=1;
				foreach ($data as $data){
					echo "
						<tr>
						<td>".$i."</td>
                        <td>".$data['nama_perangkat']."</td>
                        <td>".$data['ip_address']."</td>
						<td>".ping("182.255.0.34")."</td>
                        <td><a href='details.php?id_perangkat=".$data['id_perangkat']."'>Detail</a></td>
                        </tr>
					";
				$i++;
				}
			?>
	</table>

	<br><br>
	<a href="log_squid.php">Squid Log</a>

</html>


			