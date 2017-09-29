<?php 
session_start();

 $mid=$_GET['mid'];
 $dfolder="../design/";
 if(!$mid){header('Location: feedback_error.php');}

 include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
 $conn = connect_to_db();
 	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }

 //Get Design
 if ($stmt = mysqli_prepare($conn, "SELECT file From Design WHERE mid = ?")) {
     /* bind parameters for markers */
     mysqli_stmt_bind_param($stmt, "s", $mid);
     /* execute query */
     mysqli_stmt_execute($stmt);
     /* bind result variables */
     $stmt->store_result();

 	if($stmt->num_rows > 0) {
 	    mysqli_stmt_bind_result($stmt,$file);
 	    /* fetch value */
 	    mysqli_stmt_fetch($stmt);
 	    /* close statement */
 	    mysqli_stmt_close($stmt);
 	} else {
 	    //No Designs found
 	    header('Location: feedback_error.php');
 	}
  
 }
?>

<!DOCTYPE html>
<html>
<head>
     <script src="../js/jquery-1.11.3.min.js"></script>
     <?php include('../webpage-utility/ele_header.php'); ?>
     <title> Review My Design </title>
       
     <link rel="stylesheet" type="text/css" href="/dist/css/bootstrap.min.css">
</head>

<body>
     <div class="main-section" style="background:#F2F2F2;padding-top:50px;padding-right:50px;padding-left:50px">
     <div class="container">

      <div class="row" style="width:100%;padding-top: 20px;  margin:auto;">
        
        <!--Design -->    
        <!--<div class="row" style="width:40%;padding-top: 20px;  margin:auto;">-->
        <div class="col-md-5">    
           <img style="border: 1px solid #A4A4A4; width:100%; " id="picture" name="picture" src="<?php echo $dfolder.$file ?>" onClick="view('<?php echo $mid;?> ');" >
        </div>
        
        <div class="col-md-7">        
          <h3>Design Goals</h3> 
          <span style="font-size:16px">
              <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/design_brief.php'); ?>
          </span>
        </div>
      
      </div>


          </div>
          </div>
</body>
</html>