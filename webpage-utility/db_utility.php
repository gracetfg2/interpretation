<?php

function connect_to_db(){
   require_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_config.php');
   // Create connection
   $connection = mysqli_connect($DB_HOST,$SQL_ACC,$SQL_PWD,$DB);

   // Check connection
   if (!$connection) {
       die("Connection failed: " . mysqli_connect_error());
   }
  
   mysqli_query($connection,"SET NAMES 'utf8'");
   mysqli_query($connection,"SET CHARACTER_SET_CLIENT=utf8");
   mysqli_query($connection,"SET CHARACTER_SET_RESULTS=utf8");

   return $connection;
}

function UploadReflection($designerID, $designID, $content, $conn) {
    if (!($stmt = mysqli_prepare($conn, "INSERT INTO Reflection (DesignerID, DesignID, Content) VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE
    Content = VALUES(Content)"))) {
        echo "UploadReflection Statement Prep Failed: (" . $conn->errno . ") " . $conn->error;
    }
    $stmt->bind_param("iis", $designerID, $designID, $content);
    $stmt->execute();
    mysqli_stmt_close($stmt);
}

function CloseConnection_Util($conn) {
    mysqli_close($conn);
}
?>
