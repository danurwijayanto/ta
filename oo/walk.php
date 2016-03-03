<?php
        $syscontact = snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.1.1.0");
        echo $syscontact;
?>