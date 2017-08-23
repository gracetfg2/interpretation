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
    <?php include('../webpage-utility/ele_nav.php');?>
    <div class="container">

    <div class="alert alert-info" id="instruction">
    
       <h3>Rate Feedback</h3>
          <p> Please rate the usefulness of each piece of the feedback. You may want to consider the degree to which the feedback is useful for improving the design or gaining insight.
        </p>
    </div><!--End alert section for instruction-->

<div class="row" id="task" style="padding-top: 20px">

<div class="col-md-12">

    <form name='rating-form' id='rating-form' action='save_rating.php?design_id=<?php echo $design_id;?>' method='post'>

    <?php
        
        if(count($feedback)>0){
           
            echo "<table class='table table-hover table-nonfluid'>";
            echo " <thead>
                <td width='5%'></td>
                <td width='60%' align='left'><strong></strong></td>
                <td width='35%' align='center'><strong>Perceived Quality</strong></td>
                </thead>";
            echo " <tbody>";
                $count_feedback=1;    
            //echo count($fk_overall);
         foreach($feedback as  $value)
         {
            
                echo "<tr id='div-".$value['FeedbackID']."' >";
                    
                //*****************Changed to edited_content!!
                //$content=htmlspecialchars($value['content']);
                $content=htmlspecialchars($value['edited_content']);
                //$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
            

                echo "<td><strong>#".$count_feedback."</strong></td>
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
                </td>
                
        
                </tr>
            ";
            
                $count_feedback++;
            
        }
        echo " </tbody></table>";
                                    
             
            
        }
        else
        {
            echo "<div style='text-align:center'><p>Please contact Grace Yen at <em>design4uiuc@gmail.com</em> if your feedback does not show properly.</p></div>";
        }
        

    ?>

            <div style="text-align:center;margin-top:20px;" >
             <button type="button" class="btn btn-success" id="btn_finish" " onclick="onClickSubmit();" >Submit</button>
      </div>
                


        </div><!--End Feedback Section-->

    </div><!--End Task Section-->

  <?php include("../webpage-utility/footer.php") ?>

    </div><!--End Container-->

<!--Begin Script-->       
<script>
var hitStartTime;
var annotationFlag = false;
var annoStartTime;
var eventLogs = [];

function logAction(action, param) {
  console.log(action);
  if (typeof param === "undefined") {
    eventLogs.push([(new Date()).getTime(), action]);
  }
  else {
    //eventLogs.push([(new Date()).getTime(), action, param]);
    eventLogs.push([ param, action]);
  }
}


$(document).ready(function(){
    var isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed != "1")
        //document.getElementById("reprint").innerHTML = "<br>Your design has been reprinted several times for your ease of reference.";
    
    isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed == "1") {
        $("#response2").hide();
        $("#response3").hide();
    }
});




 function onClickSubmit(){
    
     $(':radio').each(function () {
        name = $(this).attr('name');       
         $('#div-'+name).removeClass("has-error");
    });

    var isOkay = true;
    $(':radio').each(function () {
        name = $(this).attr('name');
        if (  !$(':radio[name="' + name + '"]:checked').length) {
            $('#div-'+name).addClass("has-error");           
            isOkay = false;
        }
    });


    if(isOkay == true)  {
      
        $("#rating-form [name=prepareTime]").val( annoStartTime - hitStartTime);
        $("#rating-form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );        
        logAction("prepareTime",annoStartTime - hitStartTime);
        logAction("taskTime",(new Date()).getTime() - annoStartTime );
    
        $("#rating-form [name=_behavior]").val(JSON.stringify(eventLogs));
        $("#rating-form").submit();
        //alert("Okay");
    }
    else{
        alert("You have some feedback not been rated. (colored in red). Please rate them.");    
    }

    
 }


</script>


  </body>

</html>