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

    <div class="container">

    <div class="alert alert-info">
        <h3>Review Feedback</h3>
        <p>To help you revise your design, we have collected feedback from three independent reviewers on your initial design. For each piece of feedback, please review the content, paraphrase it, and rate its quality. When paraphrasing the feedback content, you may want to: 
        </p>
        <p>
            <li style="text-indent:20px"><b>Read </b> the feedback until you understand the meaning.</li>
            <li style="text-indent:20px"><b>Look Away</b> from the feedback to write the main points for what you read. </li>
            <li style="text-indent:20px"><b>Imagine</b> explaining those main points to your classmates or co-workers. </li>
            <li style="text-indent:20px"><b>Write</b> your explanation in the textbox below the feedback. </li>
            <li style="text-indent:20px"><b>Double check</b> your response to make sure it covers all the main points. </li>
        </p>
        <hr>
        <p>You should spend about<strong> 5 minutes reviewing and completing the task for each piece of feedback. </strong> After that, please click "Submit" to go to the next step. 
        </p>
     </div><!--End alert section for instruction-->


    <div class="row" id="task">
            <div class='panel-body'>
                <table class='table table-hover table-nonfluid'> 
                <thead>
                    <td width='10%' ></td>
                    <td width='60%' align='center'><strong></strong></td>
                    <td width='30%' align='center'><strong>Perceived Quality</strong></td>
                </thead> 

                <tbody>

                <tr id='feedback1'>
                <td><strong>#1</strong></td>

                <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>
                    The flyer did not mention the 7 am start time. It also did not mention how entrants could win $300. As is, the reader could reasonably that everyone who runs wins the money. With the dominant dark grey background and black silhouettes the flyer's design is not very visually appealing. Also, the $300 on the flyer is being blocked somewhat by one of the runner's hand, making it somewhat difficult to see
                    <hr>
                    <p><strong>Please describe the main points in this feedback using your own words:</strong></p>
                    <textarea></textarea>
                    <br><br><button type="button" class="btn btn-info" onclick="onClickSubmit(1);">Save and Review the Next Piece of Feedback</button>
                   
                </td> 
            
                <td>
                    <table border='0' cellpadding='5' cellspacing='0' width="100%">
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
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10581'  value='1' onclick='rate(this.name,1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10582'  value='2' onclick='rate(this.name,2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10583'  value='3' onclick='rate(this.name,3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10584'  value='4' onclick='rate(this.name,4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10585'  value='5' onclick='rate(this.name,5);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10586'  value='6' onclick='rate(this.name,6);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10587'  value='7' onclick='rate(this.name,7);'></td>
                            <td class='radio-label'><strong>High</strong></td>      
                        </tr>                       
                        </table>
                        
                </td>

                </tr>

                <tr id='feedback2' style="display:none;">
                <td><strong>#2</strong></td>

                <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>
                    The flyer did not mention the 7 am start time. It also did not mention how entrants could win $300. As is, the reader could reasonably that everyone who runs wins the money. With the dominant dark grey background and black silhouettes the flyer's design is not very visually appealing. Also, the $300 on the flyer is being blocked somewhat by one of the runner's hand, making it somewhat difficult to see
                    <hr>
                    <p><strong>Please describe main points in this feedback using your own words:</strong></p>
                    <textarea></textarea>
                    <br><br><button type="button" class="btn btn-info" onclick="onClickSubmit(2);">Save and Review the Next Piece of Feedback</button>
                   
                </td> 
            
                <td>
                    <table border='0' cellpadding='5' cellspacing='0' width="100%">
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
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10581'  value='1' onclick='rate(this.name,1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10582'  value='2' onclick='rate(this.name,2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10583'  value='3' onclick='rate(this.name,3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10584'  value='4' onclick='rate(this.name,4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10585'  value='5' onclick='rate(this.name,5);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10586'  value='6' onclick='rate(this.name,6);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10587'  value='7' onclick='rate(this.name,7);'></td>
                            <td class='radio-label'><strong>High</strong></td>      
                        </tr>                       
                        </table>
                        
                </td>

        </tr>


        
        <tr id='feedback3' style="display:none;">
                <td><strong>#3</strong></td>

                <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>
                    The flyer did not mention the 7 am start time. It also did not mention how entrants could win $300. As is, the reader could reasonably that everyone who runs wins the money. With the dominant dark grey background and black silhouettes the flyer's design is not very visually appealing. Also, the $300 on the flyer is being blocked somewhat by one of the runner's hand, making it somewhat difficult to see
                    <hr>
                    <p><strong>Please describe main points in this feedback using your own words:</strong></p>
                    <textarea></textarea>
                    <br><br><button type="button" class="btn btn-success" onclick="onClickSubmit(3);">Submit</button>
                   
                </td> 
            
                <td>
                    <table border='0' cellpadding='5' cellspacing='0' width="100%">
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
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10581'  value='1' onclick='rate(this.name,1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10582'  value='2' onclick='rate(this.name,2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10583'  value='3' onclick='rate(this.name,3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10584'  value='4' onclick='rate(this.name,4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10585'  value='5' onclick='rate(this.name,5);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10586'  value='6' onclick='rate(this.name,6);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='1058' id='10587'  value='7' onclick='rate(this.name,7);'></td>
                            <td class='radio-label'><strong>High</strong></td>      
                        </tr>                       
                        </table>
                        
                </td>

        </tr>



                </tbody>
                </table>






        </div><!--End Feedback Section-->

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
        window.location.href = "second_stage.php";
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