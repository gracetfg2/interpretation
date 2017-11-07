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
  

    <div class="container" style="line-height: 2em;">

      <div class="row" style="width:100%;padding-top: 20px;  margin:auto;">
        
        <!--Design -->    
        <!--<div class="row" style="width:40%;padding-top: 20px;  margin:auto;">-->
        <div class="col-md-3">    
           <img style="border: 1px solid #A4A4A4; width:100%; " id="picture" name="picture" src="<?php echo $dfolder.$file ?>" onClick="view('<?php echo $mid;?> ');" >
        </div>
        
        <div class="col-md-9">        
          <h3>Design Goals</h3> 
          <span style="font-size:16px">
              <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/design_brief.php'); ?>
          </span>
        </div>
      
      </div>


        <div class='row' style='margin-top: 20px'>
            <?php
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