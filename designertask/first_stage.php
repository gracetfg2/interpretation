<?php 
	
	session_start();	
		//************* Check Login ****************// 
	$DESIGNER= $_SESSION['designer_id'];
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//************* End Check Login ****************// 

	//Get Designer's Project
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
	include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');

   	$conn = connect_to_db();
	
	$filename="";
	$timespent="";
	$getProjectId=0;
	$getDesignId=0;
	$version=1;


	$sql10="SELECT * FROM u_Designer WHERE DesignerID=?";
		if($stmt6=mysqli_prepare($conn,$sql10))
		{
			mysqli_stmt_bind_param($stmt6,"i",$DESIGNER);
			mysqli_stmt_execute($stmt6);
			$result = $stmt6->get_result();
			$designer_info=$result->fetch_assoc() ;		 	
		 
		}

	if($designer_info['process']>2)
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
	    		mysqli_stmt_close($stmt2);	
			}
		}
		else
		{
			$getProjectId=0;
			echo "No project yet";
		}
		mysqli_stmt_close($stmt1);

	}

	if (count($design)==0)
	{
		$getDesignId=0;
		echo "No design yet";
	}
	else
	{
		foreach($design as $value)
		if ($value['version']==1)
		{
			$filename=$value['file'];
			$timespent=$value['time_spent'];
			$getDesignId=$value['DesignID'];
		}
		
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
	<div class="container ">


		<form class="form-horizontal" name="design_form" id="design_form" method="post" action="save_design.php" enctype="multipart/form-data">
		
<div style="margin-top:30px">
		<div class="panel panel-info" style="width:80%;  margin:0px auto">
  <div class="panel-heading">
    <h3 class="panel-title"> Please complete the first phase of the study by <span style="color:red"><?php echo $first_deadline;?></span></h3>
  </div>
  <div class="panel-body">
   <span class="statement" style="text-align: justify;">
   You need to design a flyer addressing the design brief and requirements below. Please upload the design image that you are satisfied with. Once you click Submit, you are not able to make further changes. Please retain a copy of the design for the next phase of the study. You need to invest approximately <strong>60 minutes </strong>designing the flyer. Now, be creative and have fun! </span>
   <h4 class="title">Rules / Requirements</h4>
    <span class="statement">
    <ol>1) You can use your favorite software to design the flyer. But no paper sketches allowed.</ol>
 <ol>2) The flyer size should be 8.5" x 11" (US Letter size) and in portrait orientation.</ol>
 <ol>3) The flyer must be created from scratch. No templates allowed.</ol>
 <ol>4) You may use images from the public domain, but not profanity, obscenity, or nudity.</ol>
 
 </span>
    <h4 class="title">Design Brief</h4>
    <span class="statement" style="text-align: justify;">
			    <ol>
			    <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/design_brief.php'); ?>

</ol>
	</span>
	

  </div>
</div>
</div>
	<hr>
	
	 <div class="form-group" id="form-group-file">
	    <label for="fileToUpload" class="col-sm-2 control-label"><?php if ($filename!=""){ echo "Change File";}else { echo "Upload File";}?><em>*</em></label>
	    <div class="col-sm-10">
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
 	<!-- <button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('save')"> Save </button>&nbsp-->
	<button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('submit')"> Submit </button>&nbsp</div>
	</div>
	<?php echo $current_projectID;?>

</div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/footer.php');
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
			// $("#error_alert").show();
		}
	
	}

</script>


 	
 </body>



</html>