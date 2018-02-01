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
    Below is a list of data we collected from our experiment. In the first column, you can see a graphic design addressing the design brief. In the second column, you can see a piece of feedback given to the design shown in the first column. <b>The designers' task is to restate the content of the feedback in the second column using their own words, and the response should cover all the content and keep the feedback's original meaning. </b><br><br>

    Your task is to read the feedback (second column) and the designers' response to the feedback (third column), and decide the quality of the designers' restatement from low (1) to high (5). You may review the rubrics before assigning the scores. 
    <br><br>
 
    - 1  : The response was not restating the meaning of the feedback. See #124 <br>
    - 2 : The response restated some points in the feedback, but missed a majority of the content in the feedback. See #1<br>
    - 3 : The response restated almost a half of the critical points in the feedback. See #10<br>
    - 4 : The response restated a majority but not all of the critical points in the feedback. <br>
    - 5 : The response restated all the critical points in the feedback. See #3 and #5.<br>
    

    
</div>
<hr>
<div class='row'>
    <strong>
        <div class='col-md-1'>#</div>
        
        <div class='col-md-3'>Design Image</div>
        <div class='col-md-5'>Feedback Content</div>
        <div class='col-md-3'>Designer's Restatement of the feedback</div>
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