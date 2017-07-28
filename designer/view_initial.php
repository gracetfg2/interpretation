<?php 
session_start();

 $mid=$_GET['mid'];
 $dfolder="../design/";
 if(!$mid){header('Location: feedback_error.php');}

 include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
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
                  <h1>Design Description</h1> <span style="font-size:24px">You have been hired to design a flyer for a half marathon race called RUN@NYC. The event will be hosted by and held at Central Park in Manhattan, New York City at 7 am on October 1, 2016. Runners can register through the event website <spen style=" text-decoration: underline;">www.running-nyc.com </spen>(not live yet). The top three runners will receive a $300 prize each. The goal of your flyer is to encourage participation, be visually appealing, and convey the event details.
     </span>   
              <h1>Your Initial Design</h1>
                          <div id="image" style="margin-top:20px">          
                               <div class="img-div" style=" margin-right:20px; " >

                               <img style="border: 1px solid #A4A4A4; width:800px; " id="picture" name="picture" src="<?php echo $dfolder.$file ?>"  >
                               </div>
                         </div>
               <!--</div>-->
               
              
               </div>




          </div>
          </div>
</body>
</html>