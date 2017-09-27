<?php 
	session_start();		
    $providerName = $_GET['designer'];
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');

?>
<html lang="en">
<head>
<title>Review Feedback </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_header.php');?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<style>
    .box {
        border: 2px solid black;
        padding: 5px;
        margin: 5px;
    }
</style>
</head>
    
<body>
  
<div class="container">
 
 <div class='well' style='padding: 20px'>  
    <h1><?php echo $providerName; ?>:</h1>
    <h4>Below is the list of feedback you have written. We expect that you provide high quality feedback for all the students. Remember that the students are novices, you need to be concise about how to improve the design. Don't be too positive. We expect that all the students can make extensive revisions on their design.</h4> 
</div>
<hr>
<div class='row'>
    <strong>
        <div class='col-md-3'>Design Image</div>
        <div class='col-md-9'><p>Feedback Content</p></div>
    </strong>
</div>
<hr>
<?php
        $feedback = array();
        $results = array();

        if ($stmt = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_providerID`=?")) {
            mysqli_stmt_bind_param($stmt, "s", $providerName);
            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($feedback, $row);
            }
        }
        foreach($feedback as $entry) {
            $designID = $entry['f_DesignID'];
            
            $image = "";
            if ($stmt = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `DesignID`=?")) {
                mysqli_stmt_bind_param($stmt, "i", $designID);
                mysqli_stmt_execute($stmt);
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $image = $row['file'];
                }
            }
            else {
                echo "Image query prepare failed: (" . $conn->errno . ") " . $conn->error;
            }
            $feedbackContent = $entry['content'];
            $feedbackRating = $entry['designer_rating'];
            $imagePath = "/interpretation/design/". $image;
            array_push($results, [$imagePath, $feedbackContent, $feedbackRating]);
            //echo "<img src=\"". $imagePath ."\">\n";
            //echo $feedbackText;
        }
                foreach($results as $res) {
                        echo "   
                        <div class='row'>
                            <div class='col-md-3'><img width='200px' border=\"2\" src=\"". $res[0] ."\" class=\"img-responsive\"></div>
                            <div class='col-md-9'><p>". $res[1] ."</p></div>

                        </div>
                        <hr>
                        ";
                    
                }
        echo"
   

        ";
        
        CloseConnection_Util($conn);
        ?>
</div>
</body>

</html>