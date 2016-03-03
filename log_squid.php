<?php
	function get_log(){
		require("function/db.php");	
		
		$query = "SELECT * 
				FROM squid_history";

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



Log SQUID Proxy<br><br>
<table border="1">
	<tr>
		<th>No</th>
		<th>Waktu</th>
		<th>IP Asal</th>
		<th>Alamat Tujuan</th>
		<th>IP Tujuan</th>
		<th>Asal Interface</th>
		<th>Asal Perangkat</th>
	</tr>

<?php
	$data = get_log();
	$i=1;
	foreach ($data as $data){
		$explode = explode(".", $data['user_ip']);
		$include = $explode[0].".".$explode[1].".".$explode[2];
		echo "
			<tr>
			<td>".$i."</td>
            <td>".$data['waktu']."</td>
            <td>".$data['user_ip']."</td>
            <td>".$data['domain_tujuan']."</td>
            <td>".$data['ip_tujuan']."</td>
            <td>".$include."</td>
            <td></td>
            </tr>
		";
		$i++;
	}
?>
</table>