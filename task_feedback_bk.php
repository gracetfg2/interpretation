<?php
 session_start();

	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
	$conn = connect_to_db();

   // Check connection
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }

/************ Get Provider IP ****************/
if(!$_SERVER['REMOTE_ADDR']){$ip="0";}
else{	$ip=$_SERVER['REMOTE_ADDR'];}

if(!$_SERVER['HTTP_X_FORWARDED_FOR']){	$proxy="0";}
else{	$proxy=$_SERVER['HTTP_X_FORWARDED_FOR'];}

$_ip = mysqli_real_escape_string($conn, $ip);
$_proxy = mysqli_real_escape_string($conn, $proxy);

$existing_turker=0;

 /************ Check Provider Existence ****************/
if ($stmt = mysqli_prepare($conn, "SELECT ProviderID From u_Provider WHERE IP = ? AND PROXY = ? ")) 
 {
    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ss",  $_ip,  $_proxy);
    /* execute query */
    mysqli_stmt_execute($stmt);
    $stmt->store_result();
    
    
    /* bind result variables */
    if($stmt->num_rows > 0) 
    {
    	$existing_turker=1;
        //existing provider
        mysqli_stmt_bind_result($stmt, $current_provider);
        /* fetch value */
        mysqli_stmt_fetch($stmt);
        $_SESSION['c_provider']=$current_provider; 
        /* close statement */
        mysqli_stmt_close($stmt);
    } 
   
 }

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
    <link rel="stylesheet" href="css/feedback.css">
   
<style>
#task {
    width: 100%;
    color:black;
    margin: 0 auto;
}

#instruction {
    width:100%; 
    text-align:justify; 
    height:auto;
    padding-left: 30px;
    padding-right: 30px;
    margin:0px auto;
    margin-bottom: 30px;
    font-size: 16px;
    color:black;
}
</style>

</head>


<body>

<div class="container" style="padding-top:20px;"> 

	    <div class="well" id="instructions" style="width:100%; font-size:16px; margin:0px auto;text-align:justify;padding-left:50px;padding-right:50px;background:#F2F2F2">				
		<h3 style="color:black;">
			<strong>
			Task Instructions
			</strong>
		</h3>
		<p>
			In this HIT, you will need to review a flyer design and its goals for at least one minute and provide feedback on the design. Your feedback should span three categories: 
            <ol>
                <li style="text-indent:20px"><b>Overall concept </b> of the design.</li>
                <li style="text-indent:20px"><b>Layout and composition </b>of the visual elements in the design.</li>
                <li style="text-indent:20px"><b>Aesthetics</b> of the design such as the color, font, and imagery choices.</li>
            </ol>
            For each category, you need to address both strengths (what you like) and weaknesses (what you don’t like) about that category of the design. 
            </p>

    	<div id="turker-div" name="turker-div"><strong> Enter your MTurk ID to start :</strong> <input type="text" id="turkerID" name="turkerID"><em style="color:red;"> (required)*</em>
    	<p><em style="color:grey">This is for the purpose of payment. </em></p>
    	</div>
	</div>


	<div id="info" name="info" style="display:none"><span style='color:red'>You have already completed the maximum number of HITs allowed in this batch. Multiple submissions will be rejected and impact your approval rate.</span></div>


<form name='response-form' id='response-form' action='save_response.php' method='post'>
	
	<div id='design-part' style="display:none">

        <div class="row" style="width:90%;padding-top: 20px;  margin:auto;">
            <div class="alert alert-info" id="instruction">
                <h3>Before writing the feedback, please read sample feedback and complete a task: </h3>             
                <p> 
           You will read three pieces of feedback, each covers one category of feedback. Each feedback provider had more than 3 years of professional experience in design. We want you to read each sentence out loud and explain what it means to you using your own words. This practice is to get you strated preparing for providing feedback. You may imagine that you are explaning the feedback to the designer. You need to write your explanation in the textbox. The response should not skip any suggestions mentioned in the feedback.
                </p>
            </div>  
        </div>

         <div><a data-toggle='collapse' href='#sample-design' aria-expanded='false' aria-controls='sample-design'>  Review the design and the design brief</a></div>


            <div style='margin-top:20px' class='collapse' id='sample-design'>  
                <div class='card card-block'>
                
                <div class="row" style="width:100%; margin:auto;"> 
                    <div class="col-md-4 col-sm-6">
                        <div class="img-div" style="cursor: pointer; margin-right:20px; " >
                             <img style="border: 1px solid #A4A4A4; width:300px; " id="picture" name="picture" src="test/initial_design.png" onClick="view();" >
                             <p><em style="color:grey">* Click on the image to enlarge </em></p>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6">
                        This is the first draft of a flyer created for a charity jazz concert featuring the band "Smooth Digital", a group of four alumni from the School of Music at the University of Illinois. The concert will take place on October 12th from 6:00 PM - 9:00 PM on the Main Quad. Tickets are $10 per person, and food and drink will also be available for purchase. All proceeds will be used to support music programs at local elementary schools. Tickets can be purchased in the Illini Union Building in Room 208. The goal of the flyer is to encourage participation, be visually appealing, and convey the event details.
                    </div>
                </div>

                </div>
            </div>	
	

        <div class='row' id="p1" >
        <div class='column-md-6'>
            <feedback><h4>Feedback #1 (Concept of the design): </h4>  Ok, so: "Smooth Digital! Cool, but, uh... Do we know them? Are they a band? What do they play?". Careful when the only giveaway that we are talking about a music show is the Sax player in the background, and right now he is more like a decoration than a proper element of the piece. Also you are taking away the main selling point of the event, we want to make profit by making a remark that this is a Charity event. Remember this is something that moves people to be there, that's why Charity drives always put that info upfront!</feedback>
            <hr>
            <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp  Please restate the meaning of feedback #1 using your own words:</h5><textarea name="f1" id="f1" monitorid="0" rows="4"></textarea>
           
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
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10581'  value='1' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10582'  value='2' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10583'  value='3' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10584'  value='4' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10585'  value='5' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10586'  value='6' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback1_rating' id='10587'  value='7' ></td>
                            <td class='radio-label'><strong>Very Useful</strong></td>      
                        </tr>                       
                        </table>
                     <hr>   
            </div><!--End of p1-->


            <div id="p2" style="display:none">
                <feedback><h4>Feedback #2 (layout and ): </h4>Great display on the information, it's the thing that pops out from it. But be careful not to block the view from the sax player, it's not entirely clear he's playing sax, and the cleanest way to save that is either taking the date and ticket price lower on the poster, right above the bottom info. Or lower the size of the sax player so he doesn't go behind the text.
                Strengths: See that triangle shape the text makes? That helps with the readability of the poster. Gives the person a direction to their sight and the info presented. Remember that when adding the missing info.
                Weaknesses: Sax player almost unrecognizable behind letters, best to keep him clear.</feedback>
                <hr>
                 <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please restate the meaning of feedback #2 using your own words:</h5><textarea name="f2" id="f2" monitorid="1" rows="4"></textarea>
         
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
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10581'  value='1'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10582'  value='2' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10583'  value='3' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10584'  value='4' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10585'  value='5' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10586'  value='6' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback2_rating' id='10587'  value='7' ></td>
                            <td class='radio-label'><strong>Very Useful</strong></td>      
                        </tr>                       
                        </table>
                      <hr> 
            </div>

            <div style="display:none" id="p3">
                <feedback><h4>Feedback #3: </h4>Besides having the sax player on full display, he can be brought up with a bit of color (as long as the attention doesn't shift to him, just enough to make him more recognizable), just stick to your color scheme so far. You can try just shadowing him with the blue like in "Smooth Digital", something discrete that makes him pop.
                Strengths: Color Scheme. Use those yellows for relevant information. But see that the contrast in "Smooth Digital" works perfectly the way it is.
                Weaknesses: Sax player almost blends with dark background. A small accent or change in color can bring him up without hoarding all the attention.</feedback>
                <hr>
                <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please restate the meaning of feedback #3 using your own words:</h5><textarea name="f3" id="f3" monitorid="2" rows="4"></textarea>
          
        
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
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10581'  value='1'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10582'  value='2' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10583'  value='3' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10584'  value='4' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10585'  value='5' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10586'  value='6' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='feedback3_rating' id='10587'  value='7'></td>
                            <td class='radio-label'><strong>Very Useful</strong></td>      
                        </tr>                       
                        </table>
                         <hr>
		      </div>

	      <button type="button" class="btn btn-success" style="margin:0px auto" id="reviewbtn" onclick="startReview()">Start Review Feedback</button>     
            

             <!--start p4-->
             <div style="display:none" id="p4">

             <div style="border-radius:20px;background-color:#cceeff; padding:30px">
             <h3> Final Survey</h3>

			 <br>
			<a href="#" data-toggle="modal" data-target="#feedbackModal" >view the feedback </a>
              <h5> 1. Based on the set of feedback, please describe how you could improve the design:<em style="color:red;"> (required)</em></h5><textarea name="action_plan" id="action_plan" onkeydown="onTextKeyDown(this.id,event)" onfocus="planAction()" monitorid="2" rows="4"></textarea>          	
           
           

                <h5> 2. How useful was performing self-explanation for improving the design? <em style="color:red;"> (required)</em></h5>
                <br>

                <table border='0' cellpadding='5' cellspacing='0' width="50%">
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
                            <td class='radio-label' >Not Useful</td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10581'  value='1'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10582'  value='2' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10583'  value='3' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10584'  value='4' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10585'  value='5' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10586'  value='6' ></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='task_useful' id='10587'  value='7'></td>
                            <td class='radio-label'>Very Useful</td>      
                        </tr>                       
                </table>
  <br>  <br>
                  <h5> 3. Please briefly explain your rating given to question 2: <em style="color:red;"> (required)</em></h5>
	 			<textarea id="explain_rating" name="explain_rating" rows="4" cols="52" style="width:100%;"></textarea>	

				<br>
				<br>
	 			<h5>4. How would you rate your level of design expertise? <em style="color:red;"> (required)</em></h5>				
					<table border="0" cellpadding="5" cellspacing="0" style="text-align: center;width:50%;">
							<td  class="radio-label" ></td>
							<td><label class="radio-cell">1</label></td> 
							<td><label class="radio-cell">2</label></td> 
							<td><label class="radio-cell">3</label></td> 
							<td><label class="radio-cell">4</label></td>
							<td><label class="radio-cell">5</label></td>
							<td><label class="radio-cell">6</label></td> 
							<td><label class="radio-cell">7</label></td>   
							<td  class="radio-label" ></td>
						</tr>
						
						<tr>
							<td class="radio-label" >Novice</td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios1" value="1"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios2" value="2"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios3" value="3"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios4" value="4"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios5" value="5"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios5" value="6"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertise" id="expertiseRadios5" value="7"></td>
						<td class="radio-label">Expert</td>		
						</tr>
					</table>
					
					<br>
					<br>

					<h5 >5. What gender do you identify with?</h5>
					<label class="radio-inline">
						<input type="radio" name="gender" id="gender1" value="male"> Male
					</label>
					<label class="radio-inline">
						<input type="radio" name="gender" id="gender2" value="female"> Female
					</label>
					<label class="radio-inline">
						<input type="radio" name="gender" id="gender3" value="other"> Other
					</label>
		
					<br>
					<br>

					<h5 >6. What is your age range? </h5>
					<label class="radio-inline">
					  <input type="radio" name="age" id="age" value="under18"> under 18
					</label>
					<label class="radio-inline">
					  <input type="radio" name="age" id="age" value="18to25"> 18-25
					</label>
					<label class="radio-inline">
					  <input type="radio" name="age" id="age" value="26to35"> 26-35
					</label>
					<label class="radio-inline">
					  <input type="radio" name="age" id="age" value="36to45"> 36-45
					</label>
					<label class="radio-inline">
					  <input type="radio" name="age" id="age" value="46to55"> 46-55
					</label>
					<label class="radio-inline">
					  <input type="radio" name="age" id="age" value="56Older"> 56 or Older
					</label>

				</div>


            </div>
            <!--end p4-->
	

<!-- Modal -->
<div id="feedbackModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-body">
       
 		<h4>Feedback 1:</h4>
 			I like the overall design it is easy to understand and the time and date of the run are all very clear and concise. The runner is a nice touch but a little choppy looking, but I do like the shadow part behind the figure. But I don't like the lack of color, it could use a pop of red or some other bright color somewhere on it.Perhaps the runner could be done in red or the shadow to give contrast behind it . Or even the font of the date in red, something to make the eye more drawn in and have it pop more in general.

 		<h4>Feedback 2:</h4>
 		I think there might be more than two fonts used, and it is a little distracting. Also, not that it is really all that important, but I can't tell from the clip art if the runner is headed toward me or away from me...and (s)he looks a little blocky and unfinished, compared to the super-HQ city image up top. Also, is the half-marathon happening at night? because the city image is night-time so that makes me wonder if it is a night-time race...

 		<h4>Feedback 3:</h4>
 		* I like the top part (image, heading font and its qualities) and the runner figure. * I don't like the middle (starting from NYC Central Park to the URL). It looks clumsy. It feels like there is too much line-spacing here, and that makes the flyer harder to read. And the typeface could be wider and of lower height - then it would be a good contrast compared to the heading and date, and thus easier for the eyes. * I'm ok with the bottom, but it would be great if it was of more color contrast compared to the background, and with more letter-spacing - so that it was easy to read from a distance. Maybe make the runner grey and the ground (which is a background for "october 1" stuff) - black? Or at least increase letter-spacing.

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




             <nav aria-label="...">
              <ul class="pager" >
                <li><button type="button" class="btn btn-default" onclick="prevPage();" id="btn_prev" style="display:none">Previous</button></li>
                <li><button type="button" class="btn btn-info" onclick="nextPage();" id="btn_next" style="display:none">Next</button></li>
                <li><button type="button" class="btn btn-success" id="btn_finish" style="display:none" onclick="submitresult();" >Submit</button></li>
              </ul>
            </nav>
	</div>



		<input type="hidden" id="_f1" name="_f1" value=""/>
		<input type="hidden" id="_f2" name="_f2" value=""/>
		<input type="hidden" id="_f3" name="_f3" value=""/>

        <input type="hidden" id="_f4" name="_f4" value=""/>
		<input type="hidden" id="_mid" name="_mid" value=""/>


		<input type="hidden" id="startTime" name="startTime" value=""/>
		<input type="hidden" id="submitTime" name="submitTime" value=""/>
		<input type="hidden" id="action_plan_time" name="action_plan_time" value=""/>
		<input type="hidden" id="reviewDesignTime" name="reviewDesignTime" value=""/>
		
		<input type="hidden" id="prepareTime" name="prepareTime" value=""/>
		<input type="hidden" id="taskTime" name="taskTime" value=""/> 	
		<input type="hidden" id="_behavior" name="_behavior" value=""/>
		<input type="hidden" id="numberOfPause" name="numberOfPause" value=""/>
		<input type="hidden" id="numberOfDel" name="numberOfDel" value=""/>

		<input type="hidden" id="group_name" name="group_name" value="explanation"/>

	</form>

	</div>

        </div><!--End Feedback Section-->

    </div><!--End Task Section-->
    
    </div><!--End Container-->

<!--Begin Script-->       
<script>
var current_page = 1;
var hitStartTime;

var annoStartTime;
var annoEndTime;

var opsCount = 0;
var typingTimer;
var doneTypingInterval = 1000;
var pauseCount = 0;
var delCount = 0;

var annotationFlag = false;
var delFlag = false;

var prevStroke;
var eventLogs = [];

function logAction(action, param) {
  console.log(action);
  if (typeof param === "undefined") {
    eventLogs.push([(new Date()).getTime(), action]);
  }
  else {
    eventLogs.push([(new Date()).getTime(), action, param]);
    //eventLogs.push([ param, action]);
  }
}


//Check TurkID 
document.getElementById('turkerID').focusout = function(e){  	
	if ($('#turkerID').val() != "") {
		turkID();
	}

};

function view() {
	window.open("pilot_view_pic.html"); 
}

function turkID() {
     
	$.post( "check_turker.php", { turker: $.trim($('#turkerID').val()) })
  	.done(function( data ) {
    
    	switch(data)
                {
                  case "exists":
                 
          			$('#design-part').hide();
          			
          			$('#info').show();
          			isOkay = false;
          			provider_ok=0;
          			//window.location.href ='already_exist.php';             
                    break;
                   case "success":
          
                   	provider_ok=1;
                  	$('#info').hide();
                  	$('#design-part').show();
                    startReview();
                    break;
                  default:
                  	
                }
  });
   
}


function prevPage()
{
    if (current_page > 1) {
        current_page--;
        changePage(current_page);
    }
}


function nextPage()
{
	var change_page = true;
	var error_msg= "";
	

	if( counting( $('#f'+current_page).val() )>1 &&  $("input[name='feedback"+current_page+"_rating']:checked").val()!=undefined){
		change_page=true;
		if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    	}
	}
	else if( counting( $('#f'+current_page).val() )<=1) 
	{
	 	error_msg+="Your response is too short, please check if you explain all the main points to the designer.";
	 	change_page=false;

	}
	else if ($("input[name='feedback"+current_page+"_rating']:checked").val()==undefined)
	{	change_page=false;
      	error_msg="You should rate the usefulness of the feedback.";
	}

	if(change_page==false){
		alert(error_msg);
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
    
    }


    if (page == 1) {
        btn_prev.style.display = "none";
    } else {
        btn_prev.style.display = "inline";
    }

    if (page == numPages()) {
    	$("#instruction").hide();
        btn_next.style.display = "none";
        btn_prev.style.display = "none";
        btn_finish.style.display ="inline";

    } else {
        btn_next.style.display = "inline";
        btn_finish.style.display ="none";
    }
}

function numPages()
{
  
    return 4;
    //return 3;
}

var review_start="";
var review_flag=false;

function startReview(){
	review_start= (new Date()).getTime();
	$("#reviewbtn").hide();
	$("#task").show();
	changePage(1);

}
 
$(document).ready(function(){
	hitStartTime = (new Date()).getTime();   
  	logAction("init");

  $(window).focus(function() {
    logAction("focus");
  });

  $(window).blur(function() {
    logAction("blur");
  });
 

	$('textarea').bind('cut copy paste', function (e) {
	    e.preventDefault(); //disable cut,copy,paste
	});



});




function counting(textvalue){
  // var value = $('#text').val();
  var value = textvalue;
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    return wordCount; 
}

function onTextKeyUp(name) {

  clearTimeout(typingTimer);
  typingTimer = setTimeout(recordPause, doneTypingInterval);
  $('#word-'+name).html(counting(document.getElementById(name).value));
  logAction(name, document.getElementById(name).value);
}

var action_plan_start='';
var action_plan_flag=false;


function planAction(){

   if (action_plan_flag == false) {
    action_plan_start = (new Date()).getTime();
    action_plan_flag = true;
    
  }
}

function onTextKeyDown(name,e) {

  if (annotationFlag == false) {
    annoStartTime = (new Date()).getTime();
    annotationFlag = true;
    logAction("start");
  }


  clearTimeout(typingTimer);
  var unicode = e.keyCode ? e.keyCode : e.charCode;
  if (unicode == 8 || unicode == 46) {
    if (!delFlag) {
      delCount += 1;
      delFlag = true;
    }
  }
  else if (delFlag) {
    delFlag = false;
  }
}

function recordPause() {
  pauseCount += 1;
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


function submitresult() {
	
	isOkay=true;
	var error_msg2='';
   	
	if(counting( $('#action_plan').val() )>10 && counting( $('#explain_rating').val() )>10&& $("input[name='task_useful']:checked").val()!=undefined){
		isOkay=true;
	}
	else if( counting( $('#action_plan').val() )<=10 ) 
	{
	 	error_msg2+="Please provide your action plan in more detail.";
	 	isOkay=false;

	}
	else if ($("input[name='task_useful']:checked").val()==undefined)
	{	
		isOkay=false;
      	error_msg2+="You should rate the usefulness of the task.";
	}
	else if(counting( $('#explain_rating').val() )<=10)
	{
		error_msg2+="Please tell us more detail about your rating given to question 2";
	 	isOkay=false;

	}


    if(isOkay==true){
      logAction("submit");

      $("#response-form [name=_f1]").val( $("#f1").val() );
      $("#response-form [name=_f2]").val( $("#f2").val() );
      $("#response-form [name=_f3]").val( $("#f3").val() );
      $("#response-form [name=_mid]").val( $("#turkerID").val() );
      $("#response-form [name=reviewDesignTime]").val( (review_start - hitStartTime)/1000) ;    
      $("#response-form [name=prepareTime]").val(( annoStartTime - hitStartTime)/1000);
      $("#response-form [name=taskTime]").val( ((new Date()).getTime() - hitStartTime)/1000 );
      $("#response-form [name=numberOfPause]").val(pauseCount);
      $("#response-form [name=action_plan_time]").val( ( ( new Date() ).getTime() - action_plan_start)/1000 );
      $("#response-form [name=numberOfDel]").val(delCount);
      $("#response-form [name=startTime]").val( annoStartTime );
      $("#response-form [name=submitTime]").val((new Date()).getTime());      
      $("#response-form").submit();
      
    }
    else
    {
       alert(error_msg2);
    }


}


</script>


  </body>

</html>