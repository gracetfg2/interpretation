<?php 
	
	session_start();	
	//************* Check Login ****************// 
	//$DESIGNER= $_SESSION['designer_id'];
	//if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//************* End Check Login ****************//

    $providerName = "Isaac";

	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');
?>
<html lang="en">
    <head>

        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

        <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_header.php');?>
        <title>Home </title>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_nav.php');?>
        <style>
            .box {
                border: 2px solid black;
                padding: 5px;
                margin: 5px;
            }
        </style>
    </head>
    
    <body>
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
        echo"<br><br><br>";
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
            $imagePath = "/interpretation/design/". $image;
            array_push($results, [$imagePath, $feedbackContent]);
            //echo "<img src=\"". $imagePath ."\">\n";
            //echo $feedbackText;
        }
        echo"
            <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
            <div class=\"container\">
            
                <h1>Review Your Feedback:</h1>
                <p>Below is all of the feedback you have written for designs. Good work!</p>
                <table class=\"table table\">
                        <thead>
                          <tr>
                            <th>Design</th>
                            <th>Your Feedback</th>
                          </tr>
                        </thead>
                        <tbody>
                ";
                foreach($results as $res) {
                        echo "   
                          <tr>
                            <td><img src=\"". $res[0] ."\" class=\"img-responsive\"></td>
                            <td><p class=\"text-center\">
                                ". $res[1] ."
                            </p></td>
                          </tr>
                        ";
                    /*echo"
                    <div class=\"row box\">
                        <div class=\"col-md-6\">
                            <img src=\"". $res[0] ."\" class=\"img-responsive\">
                        </div>
                        <div class=\"col-md-6\">
                            <p class=\"text-center\">
                                ". $res[1] ."
                            </p>
                        </div>
                    </div>";*/
                }
        echo"
                    </tbody>
                </table>
            </div>
        ";
        
        CloseConnection_Util($conn);
        ?>
    </body>
</html>