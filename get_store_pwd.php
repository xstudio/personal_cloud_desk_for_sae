<?php
include 'config/config.inc.php';
echo md5($_GET['pwd'].COMSTR);
