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
            <h3>Rate the Feedback</h3>
             <p>Before revising your design, please rate the usefulness of the feedback. You could consider the degree to which the feedback is helpful for improving your design or gaining insight. </p>
            <br>
                    <p style="font-size:16px">
   <a href='view_initial.php?mid=<?php echo $mid;?>' target="_blank"> View my initial design and design brief</a>
   </p>
         </div><!--End alert section for instruction-->

        <div >
            <?php
            include('feedback_list.php');

            if(count($feedback)<1){
                echo "<div style='text-align:center'><p>Your feedback is not ready yet, please contact Grace Yen at <em>design4uiuc@gmail.com</em></p></div>";
    
            }else{

                echo "<table class='table table-hover table-nonfluid'>";
                echo " <thead><tr>
                <td width='5%'></td>
                <td width='60%' align='left'><strong>Feedback from the providers</strong></td>
                <td width='35%' align='left'><strong>Perceived usefulness of the feedback</strong></td>
                </tr></thead> <tbody>";

                $feedbackNum = 0;
                foreach ($feedback as $value)
                {
                    $feedbackNum += 1;

                    $content=htmlspecialchars($value['interpretation']);
                    $original=htmlspecialchars($value['edited_content']);
                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

                    echo "<tr id='div-".$value['FeedbackID']."' >
                            <td><strong>#".$feedbackNum."</strong></td>
                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($original)."
                        
                            </td>  

                <td>
                <table border='0' cellpadding='5' cellspacing='0' width='100%'>
                    <tr aria-hidden='true'>
                        <td  class='radio-label'></td>
                        <td><label class='radio-cell'>1</label></td> 
                        <td><label class='radio-cell'>2</label></td> 
                        <td><label class='radio-cell'>3</label></td> 
                        <td><label class='radio-cell'>4</label></td>
                        <td><label class='radio-cell'>5</label></td> 
                        <td><label class='radio-cell'>6</label></td>
                        <td><label class='radio-cell'>7</label></td> 
                        <td  class='radio-label' ></td>
                    </tr>
                
                    <tr>
                        <td class='radio-label' ><strong>Low</strong></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."1'  value='1' "; if ($value['designer_rating']==1){echo "checked ";} echo "></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."2'  value='2' "; if ($value['designer_rating']==2){echo "checked ";} echo "></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."3'  value='3' "; if ($value['designer_rating']==3){echo "checked ";} echo "></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."4'  value='4' "; if ($value['designer_rating']==4){echo "checked ";} echo "></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."5'  value='5' "; if ($value['designer_rating']==5){echo "checked ";} echo "></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."6'  value='6' "; if ($value['designer_rating']==6){echo "checked ";} echo "></td>
                        <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."7'  value='7' "; if ($value['designer_rating']==7){echo "checked ";} echo "></td>
                        <td class='radio-label'><strong>High</strong></td>      
                    </tr>

                </table>
                </td>
                   
                    </tr>";

                }
                echo "</tbody></table>";

            }
               
                
            ?>
         
         <div style="border-radius:10px;background-color:#ffffe6; padding:30px;display:none">
                     
                    <h4><span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>&nbsp Based on the set of feedback received, please specify the strength and the weakness of your initial design, and describe what actions you will take to improve your design: </h4><textarea id="monitoredtext" monitorlabel="reflection" rows="4"><?php echo htmlspecialchars($reflection_content);?></textarea>
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

        var json = outputJSON();
        var designId=$('#design_id').val();
        post('save_task.php', {
            designIdx: designId,
            jsonGlobals: json[0],
            jsonTextareas: json[1],
            jsonRating: json[2],
            originPage: "rating.php",
            redirect: "second_stage.php"
        });

}


$(document).ready(function(){
    
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