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
    <h4>Below is a list of feedback collected for our designers. The designers were asked to rewrite the content of the feedback using their own words, and the response should cover all the content and keep the feedback's original meaning. 
    <br><br>
    Your task is to rate to what degree do you think each response covers the meaning of its original feedback.
    <br><br>
   <ul>
    <li>0%  -- The response did not address any critical insights in the feedback. </li>
    
    <li>25% -- The response convered only few insights in the feedback, missing a majority of critical points in the feedback.</li>
    <li>50% -- The response covered half of the critical insights in the feedback. </li>
    <li>75% -- The response covered a majority of critical insights in the feedback, but missing at least one or two criticle points. </li>

      <li>100% -- The response covered all the critical insights in the feedback. </li>
    


    </ul>
    </h4> 
</div>
<hr>
<div class='row'>
    <strong>
        <div class='col-md-1'>#</div>
        
        <div class='col-md-3'>Design Image</div>
        <div class='col-md-5'>Feedback Content</div>
        <div class='col-md-3'>Designer's Response</div>
    </strong>
</div>
<hr>
<?php
        $feedback = array();
        $results = array();

        if ($stmt = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID` > 26 AND `ok_to_use` = 1")) {
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
            $feedbackContent = $entry['edited_content'];
            $feedbackRating = $entry['designer_rating'];
            $response = $entry['interpretation'];
            $f_id = $entry['FeedbackID'];
            $provider = $entry['f_ProviderID'];
            $imagePath = "/interpretation/design/". $image;
            array_push($results, [$imagePath, $feedbackContent, $feedbackRating,$response, $f_id, $provider]);
            //echo "<img src=\"". $imagePath ."\">\n";
            //echo $feedbackText;
        }
         $count=0;
                foreach($results as $res) {
                       if($res[3]!=null){
                        $count++;
                        echo "   
                        <div class='row'>
                        <div class='col-md-1'>#".$count."</div>
                            <div class='col-md-3'><img width='200px' border=\"2\" src=\"". $res[0] ."\" class=\"img-responsive\"></div>
                            <div class='col-md-5'><p>". $res[1] ."</p></div>
                            <div class='col-md-3'><p>". $res[3] ."</p></div>

                        </div>
 
                        <hr>
                        ";
                    }
                    
                }
        echo"
   

        ";
        
        CloseConnection_Util($conn);
        ?>
</div>
</body>

</html>