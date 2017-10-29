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
            <h3>Review Feedback</h3>
             <p>We have collected feedback from two independent reviewers to help you revise your design. These reviewers are from the target audiences and all have more than three years of professional experience in design. Please review the feedback and rate its usefulness for improving your design. After that, please click "Next" to go to the next step.</p>
            <br>
               <a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blank"> See design description and my initial design</a>
         </div><!--End alert section for instruction-->
       
        <div id="task" style='margin-top: 10px'>
            <?php
          

            if(count($feedback)<1){
                echo "<div style='text-align:center'><p>Your feedback is not ready yet, please contact Grace Yen at <em>design4uiuc@gmail.com</em></p></div>";
    
            }else{

                echo "<table class='table table-hover table-nonfluid'>";
                echo " <thead><tr>
                <td width='5%'></td>
                <td width='60%' align='left'><strong></strong></td>
                <td width='35%' align='center'><strong>Perceived Quality</strong></td>
                </tr></thead> <tbody>";

                $feedbackNum = 0;
                foreach ($feedback as $value)
                {
                    $feedbackNum += 1;

                    $content=htmlspecialchars($value['edited_content']);
                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

                    echo "<tr id='div-".$value['FeedbackID']."' >
                            <td><strong>#".$feedbackNum."</strong></td>
                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($content)."</td>  

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
         
    
                  <div style="text-align:center;margin-top:20px;" >
                    <button style="margin:0 auto;" type="button" class="btn btn-success" onclick="submit();" id="btn_next" >Submit </button></div>
           
   
 
<input type="hidden" name="design_id" id="design_id" value="<?php echo $design_id;?>">
          

    </div><!--End Task Section-->
      <?php include("../webpage-utility/footer.php") ?>
    </div><!--End Container-->

<!--Begin Script-->       
<script>
var current_page = 1;
var isOkay = true;
    
function submit() {

 
     
     $(':radio').each(function () {
        name = $(this).attr('name');
        if ( $(':radio[name="' + name + '"]:checked').length<1) {
            $('#div-'+name).addClass("has-error");         
            isOkay = false;
            alert(name);
        }
    });


    if( isOkay ==false) {
        window.alert("Please rate the usefulness of the feedback.");
    }
    else {
        var json = outputJSON();
        var designId=$('#design_id').val();
        post('save_task.php', {
            content: '',
            designIdx: designId,
            jsonGlobals: json[0],
            jsonTextareas: json[1],
            jsonRating: json[2],
            originPage: "feedback.php",
            redirect: "second_stage.php"
        });
    }
}

$(document).ready(function(){
//nothing
 
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