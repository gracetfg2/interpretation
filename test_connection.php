<?php 


   $DB_HOST = "crowdsight.webhost.engr.illinois.edu";
   $DB = "crowdsight_interpretation";
   $SQL_ACC = "crowdsig_1";
   $SQL_PWD = "bpteam!";


   require_once('webpage-utility/db_config.php');
   // Create connection
   $connection = mysqli_connect($DB_HOST,$SQL_ACC,$SQL_PWD,$DB);

   // Check connection
   if (!$connection) {
       die("Connection failed: " . mysqli_connect_error());
   }
  
   mysqli_query($connection,"SET NAMES 'utf8'");
   mysqli_query($connection,"SET CHARACTER_SET_CLIENT=utf8");
   mysqli_query($connection,"SET CHARACTER_SET_RESULTS=utf8");




echo "test connection";


?>