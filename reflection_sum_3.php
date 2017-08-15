<?php

session_start();    
// //************* Check Login ****************// 
// $DESIGNER= $_SESSION['designer_id'];
// $EXPERIMENT=$_SESSION["experimentID"]=1;
// if(!$DESIGNER) { header("Location: ../index.php"); die(); }
// //************* End Check Login ****************// 

// include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
// $conn = connect_to_db();

// $filename="";   
//     $sql="SELECT * FROM u_Designer WHERE DesignerID=?";
//     if($stmt=mysqli_prepare($conn,$sql))
//     {
//         mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
//         mysqli_stmt_execute($stmt);
//         $result = $stmt->get_result();
//         $designer=$result->fetch_assoc() ;          
//         mysqli_stmt_close($stmt);   

//     }   


//     if($designer['process']>5 ||$designer['process']<4)
//     { header("Location: ../index.php"); die(); }


//     $sql="SELECT * FROM Design WHERE f_designerID=? AND version=?";
//     if($stmt=mysqli_prepare($conn,$sql))
//     {
//         $version=1;
//         mysqli_stmt_bind_param($stmt,"ii",$DESIGNER,$version);
//         mysqli_stmt_execute($stmt);
//         $result = $stmt->get_result();
//         $design=$result->fetch_assoc() ;            
//         mysqli_stmt_close($stmt);   
//     }
// $design_id=$design['DesignID'];
// $mid=$design['mid'];
// $ok_to_use=1;
//     if ($stmt1 = mysqli_prepare($conn, "SELECT file From Design WHERE  DesignID= ? AND f_DesignerID = ?")) {
//         mysqli_stmt_bind_param($stmt1, "ii", $design_id,$DESIGNER);
//         mysqli_stmt_execute($stmt1);
//         $stmt1->store_result();
//         if($stmt1->num_rows > 0) {
//             mysqli_stmt_bind_result($stmt1, $filename);
//             mysqli_stmt_fetch($stmt1);
//             mysqli_stmt_close($stmt1);
//             //**************** Get Feedback ****************//
//             if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Feedback` WHERE `f_DesignID`=? AND `ok_to_use`=? ORDER BY FeedbackID ASC")) {
//                 mysqli_stmt_bind_param($stmt2, "ii", $design_id, $ok_to_use);
//                 mysqli_stmt_execute($stmt2);
//                 $result = $stmt2->get_result();
//                 while ($myrow = $result->fetch_assoc()) {
//                     $feedback[]=$myrow;
//                     switch ($myrow['category']){
//                         case "'overall'":
//                             $fk_overall[]=$myrow;break;
//                         case "layout":
//                             $fk_layout[]=$myrow;break;
//                         case "aes":
//                             $fk_aes[]=$myrow;break;
//                         default:
//                             $fk_overall[]=$myrow;break;

//                     }
//                 }  
//                 $feedback_text=json_encode($feedback);
//                 mysqli_stmt_close($stmt2);  
//             }
//             else {
//             //No Designs found
//                 echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
//                 mysqli_stmt_close($stmt2);
//                 die();
//             }
            
//         }
//         else 
//         {
//             echo "You don't have the permission to view this page. If you have any questions, please contact Grace (design4uiuc@gmail.com) with error code: View-Feedback-GetDesign";die();
//         }
//     } 
//     else
//     {   
//         //mysqli_stmt_close($stmt1);
//         echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
//         die();
//     }


//     mysqli_close($conn);

    
    $feedback[0] = "feedback entry 1";
    $feedback[1] = "feedback entry 2";
    $feedback[2] = "feedback entry 3";
    $feedback[3] = "feedback entry 4";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/behavior_record_updated.js"></script>
    <!---->
    <title>Prototype</title>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/feedback.css">

</head>


<body>
    <?php include('webpage-utility/ele_nav.php');?>

    <div class="container">

        <div class="alert alert-info" id="instruction">
            <h3>Review Feedback</h3>
             <p>We have collected feedback from three independent reviewers to help you revise your design. Please review all the feedback and reflect on it by answering one question. After that, please click "Next" to go to the next step.</p>
            <br>
               <a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blanck"> See design description and my initial design</a>
         </div><!--End alert section for instruction-->

    <!--<div class="alert alert-info">
        <h3>Review Feedback</h3>
        <p>To help you revise your design, we have collected feedback from three independent reviewers on your initial design. For each piece of feedback, please <b>review</b> the content, <b>paraphrase</b> it, and <b>rate</b> its quality. When paraphrasing the feedback, please read the content until you understand it, then imagine explaining the feedback to your classmates or co-workers. We want you to write your explanation in the textbox. You should double check your response to make sure it covers all the main points in the feedback. </li>
        </p>
        <hr>
        <p>Please spend about<strong> 5 minutes reviewing and completing the task for each piece of feedback. </strong> After that, please click "Submit" to go to the next step. 
        </p>
     </div><!--End alert section for instruction-->


        <div id="task">
            <?php
                $feedbackNum = 0;
                foreach ($feedback as $indivFeedback)
                {
                    $feedbackNum += 1;
                    echo"
                        <div id=\"p1\">
                            <feedback><h4>Feedback #".$feedbackNum.": </h4>".$indivFeedback."</feedback>
                            <hr>
                        </div>";
                }
            ?>

            <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Based on the set of feedback received, please describe what actions you could take to improve your design: </h5><textarea id="monitoredtext" monitorid="0" rows="4"></textarea>
            <br>
            <button style="margin:0 auto;" type="button" class="btn btn-info" onclick="nextPage();" id="btn_next" >Next</button>
            <button style="margin:0 auto;" type="button" class="btn btn-info" onclick="printJSON();" id="btn_next" >Submit Behavior to Database</button>
   





           

    </div><!--End Task Section-->
      <?php include("webpage-utility/footer.php") ?>
    </div><!--End Container-->

<!--Begin Script-->       
<script>
var current_page = 1;

function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}

function nextPage()
{
    window.location.href = "sum_rate.php";
    
}
    
function printJSON() {
    var json = outputJSON();
    post('/submit_behavior.php/', {jsonGlobals: json[0], jsonTextareas: json[1], redirect: "/sum_rate.php/"});
}

    // https://stackoverflow.com/questions/133925/javascript-post-request-like-a-form-submit
function post(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
    
function changePage(page)
{
    var btn_next = document.getElementById("btn_next");
    var btn_prev = document.getElementById("btn_prev");
    var btn_finish = document.getElementById("btn_finish");
    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();

 
  
   for(var page_index=1; page_index<=numPages() ; page_index ++)
    {
        if(page_index == page)
        {
            $("#p"+page).show();
        }//hide pages not selected
        else
        {
           // $("#p"+page_index).hide();
        }
    
    }


    if (page == 1) {
        btn_prev.style.display = "none";
    } else {
        //btn_prev.style.display = "inline";
    }

    if (page == numPages()) {
        btn_next.style.display = "none";
        btn_finish.style.display ="inline";

    } else {
        btn_next.style.display = "inline";
        btn_finish.style.display ="none";
    }
}

function numPages()
{

    /*to do: Count Number of feedback and multiply by 2*/
    return 6;
}



function onClickSubmit(buttonNum) {
    if(buttonNum == "1") {
        $("#feedback2").show();

        //document.getElementById("area1").disabled = true;
    }
    else if(buttonNum == "2") {
        $("#feedback3").show();
        //document.getElementById("area2").disabled = true;
    }
    else if(buttonNum == "3") {
        window.location.href = "second_stage.php";
    }
}

$(document).ready(function(){

    changePage(1);

    var isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed != "1")
        //document.getElementById("reprint").innerHTML = "<br>Your design has been reprinted several times for your ease of reference.";
    
    isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed == "1") {
        $("#response2").hide();
        $("#response3").hide();
    }
});
</script>


  </body>

</html>