<?php
/******************************
The following SESSION variables will be set:
$_SESSION['designer_id']
$_SESSION['designer_group']
*****************************/

session_start();    
//************* Check Login ****************// 
$DESIGNER= $_SESSION['designer_id'];
if(!$DESIGNER) { header("Location: ../index.php"); die(); }
//************* End Check Login ****************// 

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

$filename="";   
    $sql="SELECT * FROM u_Designer WHERE DesignerID=?";
    if($stmt=mysqli_prepare($conn,$sql))
    {
        mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
        mysqli_stmt_execute($stmt);
        $result = $stmt->get_result();
        $designer=$result->fetch_assoc() ;          
        mysqli_stmt_close($stmt);   

    }   

$_SESSION['designer_group']= $designer['group'];

    if($designer['process']>5 ||$designer['process']<4)
    { header("Location: ../index.php"); die(); }


    $sql="SELECT * FROM Design WHERE f_designerID=? AND version=?";
    if($stmt=mysqli_prepare($conn,$sql))
    {
        $version=1;
        mysqli_stmt_bind_param($stmt,"ii",$DESIGNER,$version);
        mysqli_stmt_execute($stmt);
        $result = $stmt->get_result();
        $design=$result->fetch_assoc() ;            
        mysqli_stmt_close($stmt);   
    }

    $design_id=$design['DesignID'];
    $mid=$design['mid'];
    $ok_to_use=1;

    if ($stmt1 = mysqli_prepare($conn, "SELECT file From Design WHERE  DesignID= ? AND f_DesignerID = ?")) {
        mysqli_stmt_bind_param($stmt1, "ii", $design_id,$DESIGNER);
        mysqli_stmt_execute($stmt1);
        $stmt1->store_result();
        if($stmt1->num_rows > 0) {
            mysqli_stmt_bind_result($stmt1, $filename);
            mysqli_stmt_fetch($stmt1);
            mysqli_stmt_close($stmt1);
            //**************** Get Feedback ****************
            if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID`=? AND `ok_to_use`=? ORDER BY FeedbackID ASC")) {
                mysqli_stmt_bind_param($stmt2, "ii", $design_id, $ok_to_use);
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
            echo "You don't have the permission to view this page. If you have any questions, please contact Grace (design4uiuc@gmail.com) with error code: View-Feedback-GetDesign";die();
        }
    } 
    else
    {   
        //mysqli_stmt_close($stmt1);
        echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
        die();
    }



    if ($stmt_reflection = mysqli_prepare($conn, "SELECT * FROM `Reflection` WHERE `DesignerID`=? AND `DesignID`=?")) {
                mysqli_stmt_bind_param($stmt_reflection, "ii", $DESIGNER, $design_id);
                mysqli_stmt_execute($stmt_reflection);
                $result2 = $stmt_reflection->get_result();
                $myrow = $result2->fetch_assoc();
                $breaks = array("<br />");  
                $reflection_content = str_ireplace ($breaks, "\r\n", $myrow['content']);
                $feel = str_ireplace ($breaks, "\r\n", $myrow['feel']);
                $strength = str_ireplace ($breaks, "\r\n", $myrow['strength']);
    }   
    else {
    //No Designs found
        echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
     
        die();
    }

    mysqli_stmt_close($stmt_reflection);
    mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
    <script type="text/javascript" src="behavior_record_updated.js"></script>
    <!---->
    <title>Prototype</title>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="../css/feedback.css">

</head>


<body>
    <?php include('../webpage-utility/ele_nav.php');?>

    <div class="container" style="line-height: 2em;">

        <div class="alert alert-info" id="instruction">
            <h3>Reflect on the Feedback</h3>
             <p>After reviewing the feedback, we want you to reflect on the set of feedback by answering the following questions. After that, please click "Submit" to go to the next step.</p>
            <br>
            <p style="font-size:16px">
    <a href= 'vew_feedback.php?mid=<?php echo $mid;?>' target="_blanck"> See my initial design and feedback</a>
    </p>
         </div><!--End alert section for instruction-->

<div id='task'>
                     
        <h4><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>&nbsp What do I feel about the feedback: </h4><textarea id="monitoredtext" monitorlabel="reflection-feel" rows="4"><?php echo htmlspecialchars($feel);?></textarea>
        <br>

        <h4><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>&nbsp What did I do particularly well on the design? </h4><textarea id="monitoredtext" monitorlabel="reflection-strength" rows="4"><?php echo htmlspecialchars($strength);?></textarea>
        <br>

         <h4><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>&nbsp Based on the set of feedback received, what actions could I take to improve my Ddesign? </h4><textarea id="monitoredtext" monitorlabel="reflection-action" rows="4"><?php echo htmlspecialchars($reflection_content);?></textarea>
        <br>
</div>
        <div style="text-align:center;margin-top:20px;" >
        <button style="margin:0 auto;" type="button" class="btn btn-success" onclick="submit();" id="btn_next" >Submit </button></div>

 
<input type="hidden" name="design_id" id="design_id" value="<?php echo $design_id;?>">
          

    </div><!--End Task Section-->
      <?php include("../webpage-utility/footer.php") ?>
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
    //window.location.href = "sum_rate.php";
    printJSON();
}
    
function submit() {

    var isOkay=true;


    $('[id=monitoredtext]').each(function() {   // For each monitored text field...
        var text = $(this).val();       
        if(countWords(text) < 20) {           
             isOkay=false;
        }
    });


    if(isOkay==false) {
        window.alert("Please provide more detailed responses.");
    }
    else {
        var json = outputJSON();
        var designId=$('#design_id').val();
        post('save_task.php', {
            designIdx: designId,
            jsonGlobals: json[0],
            jsonTextareas: json[1],
            jsonRating: json[2],
            originPage: "reflection.php",
            redirect: "rating.php"
        });
    }
}


$(document).ready(function(){
    notifyVisible("reflection");
});

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




</script>


  </body>

</html>