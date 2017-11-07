<?php
/******************************
The following SESSION variables will be set:
$_SESSION['designer_id']
$_SESSION['designer_group']
*****************************/

session_start();    
//************* Check Login ****************// 

 $mid=$_GET['mid'];
 $dfolder="../design/";
 if(!$mid){header('Location: feedback_error.php');}

 include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
 $conn = connect_to_db();
    if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 } 

 $ok_to_use=1;

 //Get Design

    if ($stmt1 = mysqli_prepare($conn, "SELECT * From Design WHERE  mid= ?")) {
        mysqli_stmt_bind_param($stmt1, "s", $mid);
        mysqli_stmt_execute($stmt1);
        $result = $stmt1->get_result();
        $design = $result->fetch_assoc();
        //echo "wawawawawa=".$design['DesignID'];
            //**************** Get Feedback ****************
            if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID`=? AND `ok_to_use`=? ORDER BY FeedbackID ASC")) {
                mysqli_stmt_bind_param($stmt2, "ii", $design['DesignID'], $ok_to_use);
                //echo "wawawawawa=".$design['DesignID'];
                mysqli_stmt_execute($stmt2);
                $result = $stmt2->get_result();
                while ($myrow = $result->fetch_assoc()) {
                    $feedback[]=$myrow;
                }  
                $feedback_text=json_encode($feedback);
                mysqli_stmt_close($stmt2);  
            }
            else {
            //No Designs found
                echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
                mysqli_stmt_close($stmt2);
                die();
            }
            
    } 
    else
    {   
        //mysqli_stmt_close($stmt1);
        echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
        die();
    }


    $file= $dfolder.$design['file']; 
    //echo $file;
    mysqli_close($conn);


  




       echo "<div class='row' style='margin-top: 20px'>";
         
        include('feedback_list.php');

            if(count($feedback)<1){
                echo "<div style='text-align:center'><p>Your feedback is not ready yet, please contact Grace Yen at <em>design4uiuc@gmail.com</em></p></div>";
    
            }else{

                echo "<table class='table table-hover table-nonfluid'>";
                echo "<tbody>
                <thead><td></td>
                <td><strong> Feedback Content<strong></td>
                </thead>";

                $feedbackNum = 0;
                foreach ($feedback as $value)
                {
                    $feedbackNum += 1;
                    $original=htmlspecialchars($value['content']);
                    $content=htmlspecialchars($value['edited_content']);
                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

                    echo "<tr id='div-".$value['FeedbackID']."' >
                            <td><strong>#".$feedbackNum."</strong></td>
                    
                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($original)."</td> 

                       </tr>";

                }
                echo "</tbody></table>";

            }
               
                
    ?>

