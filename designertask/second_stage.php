<?php 
	
	session_start();	
	//************* Check Login ****************// 
	$DESIGNER= $_SESSION['designer_id'];
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//************* End Check Login ****************// 

	//Get Designer's Project
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');

	$filename1="";
	
//for current design
	$filename="";	
	$getProjectId=0;
	$getDesignId=0;
	$version=2;

	$sql="SELECT * FROM u_Designer WHERE DesignerID=?";
		if($stmt5=mysqli_prepare($conn,$sql))
		{
			mysqli_stmt_bind_param($stmt5,"i",$DESIGNER);
			mysqli_stmt_execute($stmt5);
			$result = $stmt5->get_result();
			$designer=$result->fetch_assoc() ;		 	
		 
		}

	if($designer['process']<4)
	{
		 header("Location: homepage.php"); die(); 
	}	

   	if ($stmt1 = mysqli_prepare($conn, "SELECT ProjectID From Project WHERE f_DesignerID = ?")) {
	    mysqli_stmt_bind_param($stmt1, "i", $DESIGNER);
	    mysqli_stmt_execute($stmt1);
	    $stmt1->store_result();
		if($stmt1->num_rows > 0) {
		    mysqli_stmt_bind_result($stmt1, $getProjectId);
		    mysqli_stmt_fetch($stmt1);
		   
		    if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `f_ProjectID`=?")) {
	    		mysqli_stmt_bind_param($stmt2, "i", $getProjectId);
	    		mysqli_stmt_execute($stmt2);
	    		$result = $stmt2->get_result();
	    		while ($row = $result->fetch_assoc()) {
	    			$design[]=$row;
	    		}  	
	   		}
		}
		else
		{

			header("Location: ../index.php"); die();
		}
		
	}

	if (count($design)==0)
	{
		//something wrong
		header("Location: ../index.php"); die();
	}
	else
	{
		foreach($design as $value)
		if ($value['version']==1)
		{
			$filename1=$value['file'];
			$initialID=$value['DesignID'];
			$mid=$value['mid'];


		}
		else if ($value['version']==2)
		{
			$filename=$value['file'];
			$getDesignId=$value['DesignID'];
		}

	}

	 //**************** Get Feedback ****************
	$ok_to_use=1;
        if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID`=? AND `ok_to_use`=? ORDER BY FeedbackID ASC")) {
            mysqli_stmt_bind_param($stmt2, "ii",$initialID, $ok_to_use);
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



 ?>
<html lang="en">
<head>
    
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
 	 
 	<?php include('../webpage-utility/ele_header.php');?>
 	 <title>Home </title>
    <!-- Custom styles for this template -->
    <style>
em{
	color:red;
}
.btn-save {
  background: #1a6b15;
  background-image: -webkit-linear-gradient(top, #1a6b15, #115724);
  background-image: -moz-linear-gradient(top, #1a6b15, #115724);
  background-image: -ms-linear-gradient(top, #1a6b15, #115724);
  background-image: -o-linear-gradient(top, #1a6b15, #115724);
  background-image: linear-gradient(to bottom, #1a6b15, #115724);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 16px;
  padding: 10px 15px 10px 15px;
  text-decoration: none;
}

.btn-save:hover {
  background: #063806;
  background-image: -webkit-linear-gradient(top, #063806, #1a4223);
  background-image: -moz-linear-gradient(top, #063806, #1a4223);
  background-image: -ms-linear-gradient(top, #063806, #1a4223);
  background-image: -o-linear-gradient(top, #063806, #1a4223);
  background-image: linear-gradient(to bottom, #063806, #1a4223);
  text-decoration: none;
  color: #ffffff;
}
.btn-submit {
  background: #e0eddf;
  background-image: -webkit-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: -moz-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: -ms-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: -o-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: linear-gradient(to bottom, #e0eddf, #c5d9cb);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;
  font-family: Arial;
  color: #6d756e;
  font-size: 16px;
  padding: 10px 15px 10px 15px;
  text-decoration: none;
}

.btn-submit:hover {
  background: #d2dbd2;
  background-image: -webkit-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: -moz-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: -ms-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: -o-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: linear-gradient(to bottom, #d2dbd2, #d9e0da);
  text-decoration: none;
    color: #6d756e;
}
.statement{
	font-size: 16px;
}
.title{
	color:#8A0808;
}

</style>
 </head>

 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_nav.php');?>




<div class="main-section">
	<div class="container " style="padding-top:50px">


		<form class="form-horizontal" name="design_form" id="design_form" method="post" action="save_design.php" enctype="multipart/form-data">
		

	<div class="panel panel-info" style=" width:80%;  margin:0px auto">
	  <div class="panel-heading">
	    <h3 class="panel-title"> Great. Now you should revise your design! </span></h3>
	  </div>
  <div class="panel-body">
		   <span class="statement" style="text-align: justify;"><p>
			Please invest around <strong> 60 minutes </strong>revising your design based on the feedback. The revised designs rated in the top ten by an independent design expert will be awarded an additional $20. Please upload an image of the revised design that you are satisfied with. Once you click Submit, no further changes are possible. The revised design and follow-up survey must be completed by <span style="color:red"><?php echo $designer['second_deadline'];?></span> and will complete the study. We hope you enjoyed the design task and look forward to your submission!
		 	
		 	<br><br>

		 	<a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blank"> View initial design and the design brief</a>
	</p>
		
		 	</span>   
  		</div>
	</div>

	<p style="font-size:16px">
            <ul>
           <li>
           
         <?php
         	switch($designer['group'])
         	{
         		case 'control':
         		case 'reflection':
         		echo "
         		<div style='background:#ffffcc; padding:1px; padding-left:1px'><h4><strong> Your Feedback<strong></h4></div>
         		<table class='table table-hover table-nonfluid'>";
                echo " 
	                    <tbody>";

	                $feedbackNum = 0;
	                foreach ($feedback as $value)
	                {
	                    $feedbackNum += 1;
	                   $content=htmlspecialchars($value['edited_content']);
	                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

	                    echo "<tr id='div-".$value['FeedbackID']."' >
	                            <td><strong>#".$feedbackNum."</strong></td>
	                    
	                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($content)."</td> 

	                       </tr>";

	                }
	                echo "</tbody></table>";
         			break;
         		case 'self_explain':
         		case 'explain_reflect';
     				echo "<div style='background:#ffffcc; padding:1px;padding-left:1px'><h4><strong> Your Response to the feedback<strong></h4></div><table class='table table-hover table-nonfluid'>";
                	echo "<tbody>
                			";

	                $feedbackNum = 0;
	                foreach ($feedback as $value)
	                {
	                   $feedbackNum += 1;
	                   $content=htmlspecialchars($value['interpretation']);
	                   $original=htmlspecialchars($value['edited_content']);
	                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

	                    echo "<tr id='div-".$value['FeedbackID']."' >
	                            <td><strong>#".$feedbackNum."</strong></td>
	                    
	                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($content)."
	                            <div style='margin-top:20px'><a data-toggle='collapse' href='#collapseExample".$feedbackNum."' aria-expanded='false' aria-controls='collapseExample".$feedbackNum."'>Read original feedback</a>


	                            <div class='collapse' id='collapseExample".$feedbackNum."'>  
	                                <div class='card card-block'>
	                                ".nl2br($original)."
	                                </div>
	                             </div>

								</td> 
	                       </tr>";

	                }
	                echo "</tbody></table>";
         			break;	

         		default:
         			break;

         	}

         	if($designer['group']=='reflection' || $designer['group']=='explain_reflect')
         	{
				    if ($stmt_reflection = mysqli_prepare($conn, "SELECT * FROM `Reflection` WHERE `DesignerID`=?")) {
				                mysqli_stmt_bind_param($stmt_reflection, "i", $DESIGNER);
				                mysqli_stmt_execute($stmt_reflection);
				                $result2 = $stmt_reflection->get_result();
				                $myrow = $result2->fetch_assoc();
				                $breaks = array("<br />");  
				                $reflection_content = str_ireplace ($breaks, "\r\n", $myrow['content']);
				                $feel = str_ireplace ($breaks, "\r\n", $myrow['feel']);
				                $strength = str_ireplace ($breaks, "\r\n", $myrow['strength']);
				    }   
				    else {
				    //No Designs found
				        echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
				     
				        die();
				    }

         		echo "<div style='background:#ffffcc; padding:1px; padding-left:1px'><h4><strong> Your Action Plan<strong></h4></div><table class='table table-hover table-nonfluid'>";
                echo " 
	                    <tbody>
	                    <tr>
	                    
	                         <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($reflection_content)."</td> 

	                     </tr>";              
	            echo "</tbody></table>";
         	}
         ?>
  
           </li>
            </ul>
            </p>
           <hr>
	 <div class="form-group" id="form-group-file">
	    <label for="fileToUpload" class="col-sm-4 col-md-4 control-label">Upload revised design<em>*</em></label>
	    <div class="col-sm-8 col-md-8">
		    <input class="input-file" id="fileToUpload" name="fileToUpload" type="file" onChange="fileUpdate(this);">
		    <p class="help-block">Only JPG, JPEG, PNG, and GIF files are allowed, the image size should be less than 5MB</p>
<img  id='current-img' name='current-img'  <?php if ($filename!="") { echo "width='80%'' height='auto' src='../design/".$filename."'";} ?> > 
		    <input type="hidden" id="exist_file" name="exist_file" value=<?php if ($filename!="") { echo "'true'"; }else { echo "'false'";}  ?> >               
		</div>
	</div>



<input type="hidden" id="update_file" name="update_file" value="false">
<input type="hidden" id="project_id" name="project_id" value=<?php echo "'".$getProjectId."'"?>>
<input type="hidden" id="action" name="action">
<input type="hidden" id="version" name="version" value=<?php echo "'".$version."'"?>>
<input type="hidden" id="design_id" name="design_id" value=<?php echo "'".$getDesignId."'"?>>

<input type="hidden" id="prepareTime" name="prepareTime" value=""/>
<input type="hidden" id="taskTime" name="taskTime" value=""/> 	
<input type="hidden" id="_behavior" name="_behavior" value=""/>

</form>

<div class="container" style="text-align:center; padding-bottom:20px;">		 	
 	<!-- <button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('save')"> Save and Return Later</button>&nbsp-->
	<button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('submit')"> Submit </button>&nbsp</div>

	</div>
	<?php echo $current_projectID;?>

</div>


<?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/footer.php');
?>
<script>
isOkay = true;
	 
// *********** Time the task
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

$(document).ready(function() {
  // var task_params = document.getElementById("survey").href.substring(56).toString();
  // (new Image).src = 'http://128.174.241.28:8080/?' + task_params;

  hitStartTime = (new Date()).getTime();
  logAction("init");

  $(window).focus(function() {
    logAction("focus");
  });

  $(window).blur(function() {
    logAction("blur");
  });

 
});




function fileUpdate(input) {

		 if (annotationFlag == false) {
		   	annoStartTime = (new Date() ).getTime();
		    annotationFlag = true;
		    logAction("start-upload-design");
		  }else{
		  		  logAction("re-uploade");
		  }
		

	 	  //check whether browser fully supports all File API
	 	 $("#form-group-file").removeClass("has-error");
	    if (window.File && window.FileReader && window.FileList && window.Blob)
	    {
	 
	        //get the file size and file type from file input field
	        var fsize = $('#fileToUpload')[0].files[0].size;
	        var ftype = $('#fileToUpload')[0].files[0].type;
	        var fname = $('#fileToUpload')[0].files[0].name;


	        //Check Size
	        if(fsize>5242880) //do something if file size more than 5 mb (5242880)
	        {
	            alert("Type :"+ ftype +" | "+ fsize +" bites\n(File: "+fname+") Too big!");
	            $('#update_file').val("false");
	        }
	        else{

	        	 //Check Type
			       switch(ftype)
			        {
			            case 'image/png':
			            case 'image/gif':
			            case 'image/jpeg':
			            case 'image/jpg':
			            case 'image/pjpeg':
			 				$('#update_file').val("true");
			 				var reader = new FileReader();
				            reader.onload = function (e) {
		        	         $('#current-img').attr('src', e.target.result);
		        	         $('#current-img').attr('width', "80%");
		        	          $('#current-img').attr('height', "auto");
		        	     	}
		          			reader.readAsDataURL(input.files[0]);
			                break;
			            default:
			            	$('#update_file').val("false");
			                alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
			          
			                break;
			        }

	        }

	    }else{

	         alert("Your broswer dosen't support file uploading, please use Google Chrome 6, Firefox 3.6, Safari 6 or IE 10+ versoin");

	        $("#fileToUpload").attr("disabled", true);
	    }




	 }



	 function save(_action) {
		 
	
		  isOkay = true;


		

		if( ( $('#update_file').val()=="false") && ($('#exist_file').val()=="false")) 
		{
			  $("#form-group-file").addClass("has-error");
			  isOkay = false;
			  alert("Please upload your design.");
		}


	    if(isOkay==true)
		{
			
		
		logAction("submit");
		$('#action').val(_action);
 		$("#design_form [name=prepareTime]").val( annoStartTime - hitStartTime);
 		$("#design_form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );		
 		logAction("prepareTime",annoStartTime - hitStartTime);
 		logAction("taskTime",(new Date()).getTime() - annoStartTime );
    	$("#design_form [name=_behavior]").val(JSON.stringify(eventLogs));		
 		$('#design_form').submit();
		
		}
		else{
			 $("#error_alert").show();
		}
	
	}

</script>


 	
 </body>
 <!--
 <p><br>Content:
	<a href= <?php //echo '../design/'.$filename1; ?> target='_blank'> Initial Design</a>&nbsp&nbsp
	<?php /*
		if($designer['group']=='feedback'||$designer['group']=='feedback-reflection'||$designer['group']=='reflection-feedback')
			echo "<a href='check_feedback.php?design_id=".$initialID."' target='_blank'>Feedback</a>&nbsp&nbsp";

		if($designer['group']=='reflection'||$designer['group']=='feedback-reflection'||$designer['group']=='reflection-feedback')
			echo "<a href='check_reflection.php'>My reflection</a>";
*/

	?>
	</p>
-->

</html>