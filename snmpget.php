<?php
	function scan_interface(){
		include "function/db.php";
		$id_if = snmpwalk("172.20.5.3", "public", ".1.3.6.1.2.1.2.2.1.1");
		$nama_if = snmpwalk("172.20.5.3", "public", ".1.3.6.1.2.1.2.2.1.2");
		$status_if = snmpwalk("172.20.5.3", "public", ".1.3.6.1.2.1.2.2.1.7");
		$panjang_if = count($id_if);
		
		for ($i=0; $i<$panjang_if; $i++){
			//echo $if[$i]."<br>";
			$if_index =  trim(eregi_replace("INTEGER: ","",$id_if[$i]),'"');
			$if_name =  trim(eregi_replace("STRING: ","",$nama_if[$i]),'"');
			$if_status = trim(eregi_replace("INTEGER: ","",$status_if[$i]),'"');
			//echo eregi_replace("STRING: ","",$if[$i])."<br>"; 
			//Simpan ke database
			$query = "INSERT INTO data_interface (id_interface, interface_index, nama_interface, status, id_perangkat)
	    				VALUES ('', '$if_index', '$if_name', '$if_status', 1)";
	    	//Query Database			
			if ($conn->query($query) === TRUE) {
			    echo "New record created successfully";
			} else {
			    echo "Error: " . $query . "<br>" . $conn->error;
			}
		}
	}

//function check_ip_status(){
//	include "function/db.php";
//	$list_ip = snmpwalk("182.255.0.34", "public", ".1.3.6.1.2.1.4.20.1.1");
	
//}

scan_interface();


//system.sysUpTime.0 = system.sysUpTime.0;
$syscontact = snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.1.1.0");
$uptime = snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.1.3.0");
$totalmem = snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.25.2.3.1.5.65536");
$usedmem = snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.25.2.3.1.6.65536");
$ipaddress = snmpwalk("182.255.0.34", "public", ".1.3.6.1.2.1.4.20.1.1");

//Menghitung panjang array
$panjangipaddress = count($ipaddress);

echo "Name : ".eregi_replace("STRING:","",$syscontact)."<br>";
echo "Uptime : ".$uptime."<br>";
echo "Total Memmory : ".eregi_replace("INTEGER:","",$totalmem)."<br>";
echo "Used Memmory : ".eregi_replace("INTEGER:","",$usedmem)."<br>";

echo "<br>Table Vlan dan Bridge<br>";
$i = 1;
$j = 1;
#echo $panjangifindex."<br>".$ifindexmentah[2]."<br>";
#foreach ($interface as $interface) {
#    echo $i." ".eregi_replace("STRING:","",$interface)."<br>";
#    $i = $i+1;
#}

echo "<table>";
echo "<tr><th>Nama Interface</th><th>IP Address</th><th>Status</th></tr>";
for ($a=0; $a<$panjangipaddress; $a++){
	$ipaddressnew = eregi_replace("IpAddress: ","",$ipaddress[$a]); 
	
	$ifindex = snmpwalk("182.255.0.34", "public", ".1.3.6.1.2.1.4.20.1.2.$ipaddressnew");	
	$ifindexnew = eregi_replace("INTEGER: ","",implode($ifindex));	
		
	$namainterface =  snmpwalk("182.255.0.34", "public", ".1.3.6.1.2.1.2.2.1.2.$ifindexnew");
	$adminstatus =  snmpwalk("182.255.0.34", "public", ".1.3.6.1.2.1.2.2.1.7.$ifindexnew");
	
	$namainterfacenew = eregi_replace("STRING: ","",implode($namainterface));
	$adminstatusnew =  eregi_replace("INTEGER: ","",implode($adminstatus));	

	echo "<tr><td>".$namainterfacenew."</td><td>".$ipaddressnew."</td><td>".(($adminstatusnew==1)?"Up":"Down")."</td></tr>";
}
echo "</table><br>";




#echo "<br>Interface Index<br>";
#foreach ($ifindex as $ifindex) {
#    $indexinterface = eregi_replace("INTEGER:","",$ifindex);
#    echo $indexinterface."<br>";
#}


?>
