<?php 
	$id = $_GET['id_perangkat'];

	function get_perangkat($id){
		require("/function/db.php");

		$query = "SELECT *
				FROM  data_perangkat
				WHERE id_perangkat=$id";
		//Query Database
		$perangkat = $conn->query($query);

		if ($perangkat->num_rows > 0) {
			while($row = $perangkat->fetch_array()) {
				$data['id_perangkat']=$row[0];
				$data['nama_perangkat']=$row[1];
				$data['ip_address']=$row[2];
			}
			return $data;
		} else {
	    	return "Tidak Ada Data";
		}
	}
	//Memperoleh detail perangkat
	$data = get_perangkat($id);
	$namper=$data['nama_perangkat'];
	$ip=$data['ip_address'];
	

	function trim_er($strings, $data){
		return trim(eregi_replace($strings,"",$data),'"');
	}

	function scan_interface(){
		include "function/db.php";
		#$id_if = snmpwalk("$GLOBALS[ip]", "public", ".1.3.6.1.2.1.2.2.1.1");
		#$nama_if = snmpwalk("$GLOBALS[ip]", "public", ".1.3.6.1.2.1.2.2.1.2");
		#$status_if = snmpwalk("$GLOBALS[ip]", "public", ".1.3.6.1.2.1.2.2.1.7");
		#$panjang_if = count($id_if);
		
		#for ($i=0; $i<$panjang_if; $i++){
		#
		#	$if_index =  trim(eregi_replace("INTEGER: ","",$id_if[$i]),'"');
		#	$if_name =  trim(eregi_replace("STRING: ","",$nama_if[$i]),'"');
		#	$if_status = trim(eregi_replace("INTEGER: ","",$status_if[$i]),'"');
		#
		#	//Simpan ke database
		#	$query = "INSERT INTO data_interface (id_interface, interface_index, nama_interface, status, id_perangkat)
	    #				VALUES ('', '$if_index', '$if_name', '$if_status', $GLOBALS[id])";
	    #	//Query Database			
		#	if ($conn->query($query) === TRUE) {
		#	    #echo "New record created successfully";
		#	} else {
		#	    echo "Error: " . $query . "<br>" . $conn->error;
		#	}
		#}
	}

	function scan_ip(){
		include "function/db.php";
		#$list_ip = snmpwalk("$GLOBALS[ip]", "public", ".1.3.6.1.2.1.4.20.1.1");
		#$ip_index = snmpwalk("$GLOBALS[ip]", "public", ".1.3.6.1.2.1.4.20.1.2");
		#$panjang_ip = count($list_ip);
		
		#for ($i=0; $i<$panjang_ip; $i++){
		#	//echo trim_er("IpAddress: ",$scan_ip['list_ip'][$i]).'||'.trim_er("INTEGER: ",$scan_ip['ip_index'][$i]).'<br>';
		#	$list_ipp = trim_er("IpAddress: ",$list_ip[$i]);
		#	$ip_indexx = trim_er("INTEGER: ",$ip_index[$i]);
		#
		#	//Simpan ke database
		#	$query = "INSERT INTO data_ipaddress (id_ipaddress, id_perangkat, ip_address, ip_addressindex)
    	#			VALUES ('', $GLOBALS[id], '$list_ipp', $ip_indexx)";
		#	
		#	//Query Database			
		#	if ($conn->query($query) === TRUE) {
		#	    #echo "New record created successfully";
		#	} else {
		#	    echo "Error: " . $query . "<br>" . $conn->error;
		#	}
		#}
	}

	function tampil(){
		include "function/db.php";
		//Print Detail Interface
		$query = "SELECT *
				FROM  data_interface LEFT JOIN data_ipaddress
				ON data_interface.interface_index=data_ipaddress.ip_addressindex AND data_interface.id_perangkat=data_ipaddress.id_perangkat
				WHERE data_interface.id_perangkat=$GLOBALS[id]";

				#SELECT a.*, b.*, d.nama_perangkat FROM data_ipaddress as a RIGHT JOIN squid_history as b on SUBSTRING_INDEX(a.ip_address, '.', 3) = SUBSTRING_INDEX(b.user_ip, '.', 3) LEFT JOIN data_interface as c on a.ip_addressindex = c.interface_index LEFT JOIN data_perangkat as d on c.id_perangkat = d.id_perangkat


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
	<?php echo "Nama Perangkat : ".$namper."<br><br>";?>
	<table border="1">
		<tr>
			<th>Nama Interface</th>
			<th>Status</th>
			<th>IP Address</th>
		</tr>
	
<?php
	scan_interface();
	scan_ip();
	$data = tampil();
	foreach ($data as $data){
		echo "
			<tr>
				<td>".$data['nama_interface']."</td>
				<td>".$data['status']."</td>
				<td>".$data['ip_address']."</td>
			</tr>

		";
	}
	//$scan_ip = scan_ip();
	//for ($i=0; $i<$scan_ip['panjang_ip']; $i++){
	//	echo trim_er("IpAddress: ",$scan_ip['list_ip'][$i]).'||'.trim_er("INTEGER: ",$scan_ip['ip_index'][$i]).'<br>';
	//}
?>
</table>