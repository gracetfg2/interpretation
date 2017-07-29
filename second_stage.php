<?php 
	


 ?>
<html lang="en">
<head>
    
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
 	 
 	<?php include('webpage-utility/ele_header.php');?>
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
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>




<div class="main-section">
	<div class="container " style="padding-top:50px">


		<form class="form-horizontal" name="design_form" id="design_form" method="post" action="save_design.php" enctype="multipart/form-data">
		

		<div class="panel panel-info" style=" width:80%;  margin:0px auto">
  <div class="panel-heading">
    <h3 class="panel-title"> Great. Now you should revise your design! </span></h3>
  </div>
  <div class="panel-body">
   <span class="statement" style="text-align: justify;"><p>

Please <strong>invest 15 to 30 minutes </strong>revising your design. This revision will be considered in the competition, and the top five designs will win an additional $20. Please upload the design image that you are satisfied with. Once you click Submit, no further changes are possible. The revision and follow-up survey must be completed by <span style="color:red"><?php echo $designer['second_deadline'];?></span> and will complete the study. We hope you enjoy the design task and look forward to your submission!
 </p>
	<p style="font-size:16px"><br>
	<a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blanck"> See my initial design and feedback</a>
	</p>
 </span>


	   
  </div>
</div>

	<hr>
	 <div class="form-group" id="form-group-file">
	    <label for="fileToUpload" class="col-sm-4 col-md-4 control-label">Upload Revised Design<em>*</em></label>
	    <div class="col-sm-8 col-md-8">
		    <input class="input-file" id="fileToUpload" name="fileToUpload" type="file" onChange="fileUpdate(this);">
		    <p class="help-block">Only JPG, JPEG, PNG, and GIF files are allowed, the image size should be less than 5MB</p>
<img  id='current-img' name='current-img'  > 
		    <input type="hidden" id="exist_file" name="exist_file" value=<?php if ($filename!="") { echo "'true'"; }else { echo "'false'";}  ?> >               
		</div>
	</div>



</form>

<div class="container" style="text-align:center; padding-bottom:20px;">		 	
 	<!-- <button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('save')"> Save and Return Later</button>&nbsp-->
	<button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('submit')" disabled> Submit [ now disabled ]</button>&nbsp</div>

	</div>


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