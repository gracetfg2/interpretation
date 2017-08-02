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
               <p>We have collected feedback from three independent reviewers to help you revise your design. These reviewers each has at least three years of experience in design. We want you to restate the meaning of the feedback using your own words and rate the usefulness of the feedback for improving your design.</p>
               <br>
               <a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blanck">  View my initial design and its description</a>
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
 
            <div style="display:none;" id="p1">
                <feedback><h4>Feedback #1: </h4>The flyer did not mention the 7 am start time. It also did not mention how entrants could win $300. As is, the reader could reasonably that everyone who runs wins the money. With the dominant dark grey background and black silhouettes the flyer's design is not very visually appealing. Also, the $300 on the flyer is being blocked somewhat by one of the runner's hand, making it somewhat difficult to see.</feedback>
                <hr>
                 <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp  Please restate the meaning of feedback #1 using your own words:</h5><textarea rows="4"></textarea>
           
                 <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please rate the usefulness of feedback #1 for improving your design:</h5>
                <br>

                <table border='0' cellpadding='5' cellspacing='0' width="70%">
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
                            <td class='radio-label' ><strong>Not Useful</strong></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10581'  value='1' onclick='rate(this.name,1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10582'  value='2' onclick='rate(this.name,2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10583'  value='3' onclick='rate(this.name,3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10584'  value='4' onclick='rate(this.name,4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10585'  value='5' onclick='rate(this.name,5);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10586'  value='6' onclick='rate(this.name,6);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10587'  value='7' onclick='rate(this.name,7);'></td>
                            <td class='radio-label'><strong>Very Useful</strong></td>      
                        </tr>                       
                        </table>
                     <hr>   
            </div>


            <div style="display:none;" id="p2">
                <feedback><h4>Feedback #2: </h4>The design is very simple and the silhouette of the male and female runners is a nice touch showcasing a triumphant victory. The message is simple and straightforward, however the colors used are very dull and do not grab my attention. The only bright red ribbons around the torsos of the runners are not adequate to draw attention to the flyer. Also, it shows the male runner being further ahead than the female runner which might send an undesirable subliminal message. In addition, the $300 prize is stated in the description to go to the top 3 winners, but this is not mentioned on the flyer and the time of the event is not included either.</feedback>
                <hr>
                 <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please restate the meaning of feedback #2 using your own words:</h5><textarea rows="4"></textarea>
         
                <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please rate the usefulness of feedback #2 for improving your design:</h5>
                <br>
                <table border='0' cellpadding='5' cellspacing='0' width="70%">
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
                            <td class='radio-label' ><strong>Not Useful</strong></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10581'  value='1' onclick='rate(this.name,1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10582'  value='2' onclick='rate(this.name,2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10583'  value='3' onclick='rate(this.name,3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10584'  value='4' onclick='rate(this.name,4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10585'  value='5' onclick='rate(this.name,5);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10586'  value='6' onclick='rate(this.name,6);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10587'  value='7' onclick='rate(this.name,7);'></td>
                            <td class='radio-label'><strong>Very Useful</strong></td>      
                        </tr>                       
                        </table>
                        <hr>
            </div>

            <div style="display:none" id="p3">
                <feedback><h4>Feedback #3: </h4>I like that it gets the point across well. But the color palette is weak in my opinion. I would change the silhouette, as well as change the color of the background to something lighter (maybe pastels?)</feedback>
                <hr>
                <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please restate the meaning of feedback #3 using your own words:</h5><textarea rows="4"></textarea>
          
        
                 <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please rate the usefulness of feedback #3 for improving your design:</h5>
                <br>

                <table border='0' cellpadding='5' cellspacing='0' width="70%">
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
                            <td class='radio-label' ><strong>Not Useful</strong></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10581'  value='1' onclick='rate(this.name,1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10582'  value='2' onclick='rate(this.name,2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10583'  value='3' onclick='rate(this.name,3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10584'  value='4' onclick='rate(this.name,4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10585'  value='5' onclick='rate(this.name,5);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10586'  value='6' onclick='rate(this.name,6);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10587'  value='7' onclick='rate(this.name,7);'></td>
                            <td class='radio-label'><strong>Very Useful</strong></td>      
                        </tr>                       
                        </table>
                  <hr>      
            </div>



            <nav aria-label="...">
              <ul class="pager" >
                <li><button type="button" class="btn btn-default" onclick="prevPage();" id="btn_prev" style="display:none">Previous</a></li>
                <li><button type="button" class="btn btn-info" onclick="nextPage();" id="btn_next" style="display:none">Next</a></li>
                <li><button type="button" class="btn btn-success" id="btn_finish" style="display:none" onclick="onClickSubmit(3);" >Go to Next Step </a></li>
              </ul>
            </nav>

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

    /*to do: Count Number of feedback and multiply by 2*/
    return 3;
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