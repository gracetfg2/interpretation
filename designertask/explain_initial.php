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
$_SESSION['designer_group']=$designer['group'];


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


    if (count($design)>0) {

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
        //mysqli_stmt_close($stmt1);
        echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: EXPLAIN";
        die();
    }

    switch($designer['group'])
    {
        case 'self_explain':
            $next_page= "rating.php";
            break;
        case 'explain_reflect':
            $next_page= "reflection_second.php";
            break;
        case 'default':
            echo "Something wrong here. Please contact Grace at design4uiuc@gmail.com";
            die();
            break;

    }
  
 //  $next_page="second_stage.php";

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
    <title>Review Feedback</title>
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

        <div id='task-inst'>
            <h3>Review Feedback</h3>
            <p style="font-size:20px">We have collected feedback from two independent reviewers to help you revise your design. These reviewers have at least three years of professional experience in design. To ensure that you fully comprehend the feedback, we want you to <strong>rewrite the content of the feedback using your own words</strong>. Your response should cover all the content and keep its original meaning. Do NOT write anything beyond the explanation of the feedback (e.g. do NOT write action plan).
            </p>

                <br>
            
            <button type="button" class="btn btn-success" style="margin:0px auto" id="reviewbtn" onclick="ReadExample()">Next</button>  
        </div>

        <div id='example-panel' style='display:none;'>

        <h3>Read an example of the restating task:</h3>
        <br>
        <div class='row'>

        <div class='col-md-6'>
        <h4>Feedback from the reviewer:</h4>
            <p style='font-size: 16px'>
               I'm ok with the bottom, but it would be great if it was of more color contrast compared to the background, and with more letter-spacing - so that it was easy to read from a distance. Should at least increase letter-spacing.
            </p>
        </div>

        <div class='col-md-6' style='height:250px'>
            <h4> Response from the designer:</h4>
            <textarea id='sample' style='font-size: 14px;'>The reviewer didn't like the bottom part of the flyer because it does not give enough color contrast. I think this is probably because I set the background color too dark and used a dark green for the text. Also, the letter-spacing is too small, making it hard to be read from a distance. The least thing I should do is to increase the letter-spacing.
            </textarea>
        </div>
        </div>
            <button type="button" class="btn btn-success" style="margin:0px auto" id="reviewbtn" onclick="startReview()">Next</button> 

      
        </div>
        

        </div><!--End alert section for instruction-->


    <div id="task" style='display:none;'>
    <div>
        <div class="alert alert-info" id="instruction">
            <h3>Restate Your Feedback :</h3>
             <p>To ensure that your understand the feedback, please restate the content of the feedback using your own words. Your responses should cover all the content and keep its original meaning. Do NOT write anything beyond the explanation of the feedback (e.g. do NOT write action plan).</p>
             <p>Please invest approximately 10 minutes per feedback. There are in total two pieces of feedback.</p>
            <br>
             <span style='color:grey'><em> Note: Copy and paste functions are disabled on the task pages.   </em></span>
            <p style="font-size:16px">
            <a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blank"> Open your initial design and the design brief</a>
            </p>
         </div><!--End alert section for instruction-->

    </div>
        <?php
            $feedbackNum = 0;
            foreach ($feedback as $value)
            {
                $feedbackNum += 1;
                $content=htmlspecialchars($value['edited_content']);                 
                $breaks = array("<br />");  
                $interpretation = str_ireplace ($breaks, "\r\n", $value['interpretation']);
                echo"
                    <div class='well well-lg' style=\"display:none; min-height: 300px;\" id=\"p".$feedbackNum."\">      
                        <div class='row'>
                        
                            <div class='col-md-6'>     
                                <h4>Feedback #".$feedbackNum.": </h4>                                       
                                <p>".nl2br($content)."</p>
                            </div>
                              <div class='col-md-6'>   
                                <h5><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>&nbsp  Rewrite feedback #".$feedbackNum." using your own words. Your response should cover the content of the feedback completely:</h5>

                                <textarea style='font-size:14px' onkeyup=\"textAreaAdjust(this)\" style=\"overflow:hidden; min-height: 150px;\" onpaste='return false;' rows='50' id=\"monitoredtext\" monitorlabel=\"explain".$feedbackNum."-".$value['FeedbackID']."\">".htmlspecialchars($interpretation)."</textarea>
                            </div> 
                        </div>         
                    </div>";
                  echo "<input type='hidden' name='fid".$feedbackNum ."' id='fid".$feedbackNum ."' value='".$value['FeedbackID']."'>";  
            }
        ?>
        <div style='height:50px'></div>
            <nav aria-label="..." >
              <ul class="pager" >
                <li><button type="button" class="btn btn-default" onclick="prevPage();" id="btn_prev" style="display:none">Previous feedback</button></li>
                <li><button type="button" class="btn btn-info" onclick="nextPage();" id="btn_next" style="display:none">Next feedback</button></li>
                <li><button type="button" class="btn btn-success" id="btn_finish" style="display:none" onclick="submit();" >Save responses and go to next step </button></li>
              </ul>
            </nav>
   

<input type="hidden" name="next_page" id="next_page" value="<?php echo $next_page;?>">
<input type="hidden" name="design_id" id="design_id" value="<?php echo $design_id;?>">

    </div><!--End Task Section-->
      <?php include("../webpage-utility/footer.php") ?>
    </div><!--End Container-->

<!--Begin Script-->       
<script>

function startReview(){
    $("#task").show();
    $("#instruction").hide();
    $("#example-panel").hide();
}



function ReadExample(){
     $("#example-panel").show();
      $("#task-inst").hide();
}

function isRadioButtonChecked(page) {
    //return isRadioChecked;
    var ret = false;
    $('td').each(function() {
        if($(this).find('input:radio:checked').length != 0 && $(this).is(':visible') == true) {
            ret = true;
        }
    });
    return ret;
}

var current_page = 1;

function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page, current_page + 1);
    }
}

function nextPage()
{
    var label = "explain" + current_page + "-" + $('#fid'+current_page).val();
    var contentVal = $("textarea[monitorlabel='" + label + "']").val();
   
    if(countWords(contentVal) < 20) {
        window.alert("Your response is too short, please check if your response covers all the insights provided in this feedback.");
    }
    else if (current_page < numPages()) {
        current_page++;
        changePage(current_page, current_page - 1);
    }
   // window.scrollTo(0,document.body.scrollHeight);
}
    

function changePage(page, oldPage)
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
    
    var newLabel = "explain" + page + "-" + $('#fid'+page).val();
    var oldLabel = "explain" + oldPage + "-" + $('#fid'+oldPage).val();
    if(page != oldPage)
        notifyHidden(oldLabel);
    notifyVisible(newLabel);
}

function numPages()
{

    var feedbackCount = <?php Print(count($feedback)); ?>;
    return feedbackCount;

}

function submit() {
     var label = "explain" + current_page + "-" + $('#fid'+current_page).val();
    var contentVal = $("textarea[monitorlabel='" + label + "']").val();
       logAction("submit");
    if(countWords(contentVal) < 20) {
        window.alert("Your response is too short, please check if your response covers all the insights provided in this feedback.");
    }
    else {       
        var json = outputJSON();
        var designId= $('#design_id').val();
    
        post('save_task.php', {
            designIdx: designId, 
            jsonGlobals: json[0], 
            jsonTextareas: json[1], 
            jsonRating: json[2],
            jsonLog: json[3],
            originPage: "explain_initial.php",
            redirect: $('#next_page').val()
        });
    }
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

function textAreaAdjust(o) {
  o.style.height = "1px";
  o.style.height = (155+o.scrollHeight)+"px";
}

$(document).ready(function(){
    changePage(1,1);


});
</script>


  </body>

</html>