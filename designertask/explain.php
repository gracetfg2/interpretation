<?php

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
            //**************** Get Feedback ****************//
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


    $next_page= ($designer['group'] == 'self_explain') ? "second_stage.php" : "reflection.php";
   
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
    <!---->
    <title>Prototype</title>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="../css/feedback.css">

</head>


<body>
    <?php
        include('../webpage-utility/ele_nav.php');
    ?>
    <script type="text/javascript" src="behavior_record_updated.js"></script>
    <div class="container">

        <div class="alert alert-info" id="instruction">
            <h3>Review Feedback</h3>
               <p>We have collected feedback from three independent reviewers to help you revise your design. These reviewers each has at least three years of experience in design. We want you to restate the meaning of the feedback using your own words and rate the usefulness of the feedback for improving your design.</p>
               <br>
               <a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blanck">  View my initial design and its description</a>
         </div><!--End alert section for instruction-->


    <div id="task">
        <?php
            $feedbackNum = 0;
            foreach ($feedback as $value)
            {
                $feedbackNum += 1;
                $content=htmlspecialchars($value['edited_content']);
                   
                echo"
                    <div style=\"display:none;\" id=\"p".$feedbackNum."\">
                        <feedback><h4>Feedback #".$feedbackNum.": </h4>".nl2br($content)."</feedback>
                        <hr>
                        <h5><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>&nbsp  Please restate the meaning of feedback #".$feedbackNum." using your own words:</h5><textarea rows=\"4\" id=\"monitoredtext\" monitorid=\"".$feedbackNum."\"></textarea>

                        <h5><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>&nbsp Please rate the usefulness of feedback #".$feedbackNum." for improving your design:</h5>
                        <br>

                        <table border='0' cellpadding='5' cellspacing='0' width=\"50%\">
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
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."1'  value='1' "; if ($value['designer_rating']==1){echo "checked ";} echo "onclick='rate(this.name,1);'></td>
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."2'  value='2' "; if ($value['designer_rating']==2){echo "checked ";} echo "onclick='rate(this.name,2);'></td>
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."3'  value='3' "; if ($value['designer_rating']==3){echo "checked ";} echo "onclick='rate(this.name,3);'></td>
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."4'  value='4' "; if ($value['designer_rating']==4){echo "checked ";} echo "onclick='rate(this.name,4);'></td>
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."5'  value='5' "; if ($value['designer_rating']==5){echo "checked ";} echo "onclick='rate(this.name,5);'></td>
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."6'  value='6' "; if ($value['designer_rating']==6){echo "checked ";} echo "onclick='rate(this.name,6);'></td>
                    <td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."7'  value='7' "; if ($value['designer_rating']==7){echo "checked ";} echo "onclick='rate(this.name,7);'></td>
                    <td class='radio-label'><strong>High</strong></td>      
                </tr>                       
                        </table>
                         
                    </div>";
            }
        ?>
        

            <nav aria-label="...">
              <ul class="pager" >
                <li><button type="button" class="btn btn-default" onclick="prevPage();" id="btn_prev" style="display:none">Previous</a></li>
                <li><button type="button" class="btn btn-info" onclick="nextPage();" id="btn_next" style="display:none">Next</a></li>
                <li><button type="button" class="btn btn-success" id="btn_finish" style="display:none" onclick="onClickSubmit();" >Go to Next Step </a></li>
              </ul>
            </nav>
   

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
    if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    }
   // window.scrollTo(0,document.body.scrollHeight);
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
            $("#p"+page_index).hide();
        }
    
    }


    if (page == 1) {
        btn_prev.style.display = "none";
    } else {
        btn_prev.style.display = "inline";
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

    var feedbackCount = <?php Print(count($feedback)); ?>;
    return feedbackCount;

}



function onClickSubmit() {

    var json = outputJSON();
  

    post('submit_behavior.php', {jsonGlobals: json[0], jsonTextareas: json[1], redirect: "<?php echo $nextPage; ?>"} );
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

$(document).ready(function(){

    changePage(1);

});
</script>


  </body>

</html>