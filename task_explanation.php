<?php
 session_start();

   $DB_HOST = "crowdsight.web.engr.illinois.edu";
   $DB = "crowdsight_interpretation";
   $SQL_ACC = "crowdsig_1";
   $SQL_PWD = "bpteam!";

   $conn = mysqli_connect($DB_HOST,$SQL_ACC,$SQL_PWD,$DB);

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
			In this HIT, we want to learn more about how designers read and learn from feedback, as well as what makes some feedback better than others. Imagine yourself as a design consultant and do the following: 

			<li> review a graphic design and its goals for at least one minute.</li>
			<li> review three pieces of feedback collected from the target audience of this poster. </li>
			<li> recommend actions to improve the design.</li>
			</p>


	<div id="turker-div" name="turker-div"><strong> Enter your MTurk ID to start :</strong> <input type="text" id="turkerID" name="turkerID"><em style="color:red;"> (required)*</em>
	<p><em style="color:grey">This is for the purpose of payment. </em></p>
	</div>

	</div>


	<div id="info" name="info" style="display:none"><span style='color:red'>You have already completed the maximum number of HITs allowed in this batch. Multiple submissions will be rejected and impact your approval rate.</span></div>


<form name='response-form' id='response-form' action='save_response.php' method='post'>
	
	<div id='design-part' style="display:none">
     	<div class="row" style="width:100%;padding-top: 20px;  margin:auto;">

			<div class="col-md-3" id="image" style="margin-top:20px">		
				 <div class="img-div" onmouseover="" style=" cursor: pointer; margin-right:20px; " >

				 <img style="border: 1px solid #A4A4A4; width:400px; " id="picture" name="picture" src="test/exampledesign.jpg" onClick="view();" >
				 <p><em style="color:grey">* Click on the image to enlarge </em></p>
				</div>
			</div>

			<div class="col-md-9">
			<h3>Design Goals</h3> <span style="font-size:16px">This is the first draft of a flyer created for a half marathon race called RUN@NYC. The event will be hosted by and held at Central Park in Manhattan, New York City at 7 am on October 1, 2016. Runners can register through the event website <spen style=" text-decoration: underline;">www.running-nyc.com </spen>(not live yet). The top three runners will receive a $300 prize each. The goal of the flyer is to encourage participation, be visually appealing, and convey the event details.
			<p><br>You can click on the image to enlarge.</p></span>

			</div>


			<button type="button" class="btn btn-success" style="margin:0px auto" id="reviewbtn" onclick="startReview()">Start Review Feedback</button>
		</div>
	</div>
		
	<hr>

	<div id="task" style="display:none">

 		<div class="alert alert-info" id="instruction">
			<h3>Now, please review the feedback.</h3> 
			<p>
					For each piece of feedback, we want you to read each sentence out loud and then explain what
					it means to you. You may imagine that you are explaning the feedback to the designer. You need to restate the meaning of the content using your own words and rate the usefulness of the feedback for improving the design. Your response should cover all the points mentioned in the feedback whether you agree with it or not. 


					<br><br>Responses that demonstrate insufficient effort will be rejected. 


			</p>
		</div>

 
            <div id="p1" style="display:none;" >
                <feedback><h4>Feedback #1: </h4>The flyer did not mention the 7 am start time. It also did not mention how entrants could win $300. As is, the reader could reasonably that everyone who runs wins the money. With the dominant dark grey background and black silhouettes the flyer's design is not very visually appealing. Also, the $300 on the flyer is being blocked somewhat by one of the runner's hand, making it somewhat difficult to see.</feedback>
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
            </div>


            <div style="display:none;" id="p2">
                <feedback><h4>Feedback #2: </h4>The design is very simple and the silhouette of the male and female runners is a nice touch showcasing a triumphant victory. The message is simple and straightforward, however the colors used are very dull and do not grab my attention. The only bright red ribbons around the torsos of the runners are not adequate to draw attention to the flyer. Also, it shows the male runner being further ahead than the female runner which might send an undesirable subliminal message. In addition, the $300 prize is stated in the description to go to the top 3 winners, but this is not mentioned on the flyer and the time of the event is not included either.</feedback>
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
                <feedback><h4>Feedback #3: </h4>I like that it gets the point across well. But the color palette is weak in my opinion. I would change the silhouette, as well as change the color of the background to something lighter (maybe pastels?)</feedback>
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


             <div style="display:none" id="p4">
              <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Based on the set of feedback, please describe how you could improve the design:</h5><textarea name="action_plan" id="action_plan" onkeydown="onTextKeyDown(this.id,event)" onfocus="planAction()" monitorid="2" rows="4"></textarea>
          	
           
                <h5><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp Please rate the usefulness of the self-explanation process:</h5>
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

//viewwin = window.open(imgsrc.src,'viewwin', 'width=1000,height=auto'); 
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
var change_page = true;

function nextPage()
{
	var error_msg= "";
	

	if( counting( $('#f'+current_page).val() )>2 &&  $("input[name='feedback"+current_page+"_rating']:checked").val()!=undefined){
		change_page=true;
		if (current_page < numPages()) {
        current_page++;
        changePage(current_page);
    	}
	}
	else if( counting( $('#f'+current_page).val() )<=2) 
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
      $("#response-form [name=action_plan_time]").val( ((new Date()).getTime() - action_plan_start)/1000 );
      $("#response-form [name=numberOfDel]").val(delCount);
      $("#response-form [name=startTime]").val( annoStartTime );
      $("#response-form [name=submitTime]").val((new Date()).getTime());
      alert((review_start - hitStartTime)/1000);
     
     $("#response-form").submit();
      
    }
    else
    {
       $("#error_alert").show();
    }


}


</script>


  </body>

</html>