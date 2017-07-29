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
     <link rel="stylesheet" href="css/feedback.css">
</head>


<body>
  <?php include('webpage-utility/ele_nav.php');?>
    <div class="container">

    <div class="alert alert-info" id="instruction">
    
       <h3>Review Feedback</h3>
          <p>To help you revise your design, we have collected feedback from three independent reviewers on your initial design. Below we present your initial design on the left and feedback on the right. We want you to read the set of feedback until you understand it, then imagine explaining it to your classmates or co-workers. You need to write your explanation in the textbox. After that, double check your response to make sure it covers all the main points in the feedback. </li>
        </p>
        <hr>
        <p>Please spend about<strong> 15 minutes reviewing and completing the task for the set of feedback. </strong> After that, please click "Save and Go to Next Step". 
        </p>
    </div><!--End alert section for instruction-->


    <div class="row" id="task">
        <div class="col-md-5 col-sm-5" style="padding-top:10px">            
            <img style="border: 1px solid #A4A4A4; width:800px;"  src="test/exampledesign.jpg">
        </div><!--End Design Image-->

        <div class="col-md-7 col-sm-7">   
            <div id="p1">
                <feedback>The flyer did not mention the 7 am start time. It also did not mention how entrants could win $300. As is, the reader could reasonably that everyone who runs wins the money. With the dominant dark grey background and black silhouettes the flyer's design is not very visually appealing. Also, the $300 on the flyer is being blocked somewhat by one of the runner's hand, making it somewhat difficult to see.</feedback>
                <hr>
                </div>


            <div id="p3">
                <feedback>The design is very simple and the silhouette of the male and female runners is a nice touch showcasing a triumphant victory. The message is simple and straightforward, however the colors used are very dull and do not grab my attention. The only bright red ribbons around the torsos of the runners are not adequate to draw attention to the flyer. Also, it shows the male runner being further ahead than the female runner which might send an undesirable subliminal message. In addition, the $300 prize is stated in the description to go to the top 3 winners, but this is not mentioned on the flyer and the time of the event is not included either.</feedback>
                <hr>
            </div>


            <div id="p5">
                <feedback>I like that it gets the point across well. But the color palette is weak in my opinion. I would change the silhouette, as well as change the color of the background to something lighter (maybe pastels?)</feedback>
                <hr>
                
            </div>

            <h4>Please explain the set of feedback to us using your own words:</h4>
            <textarea rows="4"></textarea>

            <div style="margin-top:20px;">
             <button type="button" class="btn btn-success" id="btn_finish" onclick="onClickSubmit(3);" >Save and Go to Next Step </button>
            </div>



        </div><!--End Feedback Section-->

    </div><!--End Task Section-->

  <?php include("webpage-utility/footer.php") ?>

    </div><!--End Container-->

<!--Begin Script-->       
<script>
function toggleDelayed() {
    var isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed == "1")
        isDelayed = "0";
    else
        isDelayed = "1";
    localStorage.setItem("isDelayed", isDelayed);
    location.reload();
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
        window.location.href = "sum_rate.php";
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
</script>


  </body>

</html>