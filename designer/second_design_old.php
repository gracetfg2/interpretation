<?php 
	
	session_start();	
	//************* Check Login ****************// 
	$DESIGNER= $_SESSION['designer_id'];
	$EXPERIMENT=$_SESSION["experimentID"]=1;
	if(!$DESIGNER) { header("Location: ../reflection/index.php"); die(); }
	//************* End Check Login ****************// 

	//Get Designer's Project
	include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	
	$filename1="";
	
//for current design
	$filename="";	
	$getProjectId=0;
	$getDesignId=0;
	$currentVersion=2;


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

			header("Location: ../reflection/index.php"); die();
		}
		mysqli_stmt_close($stmt1);

	}

	if (count($design)==0)
	{
		//something wrong
		header("Location: ../reflection/index.php"); die();
	}
	else
	{
		foreach($design as $value)
		if ($value['version']==1)
		{
			$filename1=$value['file'];
		}
		else if ($value['version']==2)
		{
			$filename=$value['file'];
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
	text-align:justify;
	font-size: 16px;
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
.title{
	color:#8A0808;
}

</style>
 </head>

 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>

<div class="main-section">
	<div class="container">

		
		<form class="form-horizontal" name="design_form" id="design_form" method="post" action="save_design.php" enctype="multipart/form-data">


<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-title"> Revise You Design and Submit </h3>
  </div>
  <div class="panel-body">
   <div class="statement"> On this page, you need to apply what you learn from the reflection process to make a second iteration of your design. The revised design will enter the selection process. The top three designs will be rewarded a bonus of $20 US dollars. Good luck! </div>

   Please invest about 20 minutes performing the revision.
   <hr>

  <!-- <div class="row">
   <div class="col-md-5">
  
   <h4>Task Descrition</h4> 
     <div class="statement">
   <?php include("../designer/task_description.php");?></div>
   </div>
   <div class="col-md-7">
   	
   </div>
    </div>
  </div>
-->
</div>



<table class="table table-bordered" style="text-align:center">
    <thead>
      <tr class="warning" >
        <th style="text-align:center"><div class="form-group" id="form-group-file"><label class="control-label">Initial Design</label></div></th>
        <th>
        	
        	<div class="form-group" id="form-group-file">
	    <label for="fileToUpload" class="col-sm-6 control-label"><?php if ($filename!=""){ echo "Change Revised Design";}else { echo "Upload Revised File";}?><em>*</em></label>
	    <div class="col-sm-6">
		    <input class="input-file" style="padding-top: 5px" id="fileToUpload" name="fileToUpload"  type="file" onChange="fileUpdate(this);" />
   
		    <input type="hidden" id="exist_file" name="exist_file" value=<?php if ($filename!="") { echo "'true'"; }else { echo "'false'";}  ?> >               
		</div>
	</div>


        </th>
				
      </tr>
    </thead>
    <tbody>
   	 <tr>
    	<td width="50%"><img  width="80%" height="auto" src="<?php echo "../design/".$filename1; ?>" ></td>
    	<td width="50%"><img  id='current-img' name='current-img'  <?php if ($filename!="") { echo "width='80%'' height='auto' src='../design/".$filename."'";} ?> ></td>
	
     </tr>
      
    </tbody>
  </table>






			 <input type="hidden" id="update_file" name="update_file" value="false">
			 <input type="hidden" id="project_id" name="project_id" value=<?php echo "'".$getProjectId."'"?>>
			 <input type="hidden" id="action" name="action">
			 <input type="hidden" id="version" name="version" value=<?php echo "'".$currentVersion."'"?>>
			 <input type="hidden" id="design_id" name="design_id" value=<?php echo "'".$getDesignId."'"?>>

			 <input type="hidden" id="prepareTime" name="prepareTime" value=""/>
			<input type="hidden" id="taskTime" name="taskTime" value=""/> 	
			<input type="hidden" id="_behavior" name="_behavior" value=""/>
	
		</form>

		<div class="container" style="text-align:center; padding-bottom:20px;">		 	
		 	 <button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('save')"> Save </button>&nbsp
			<button type="submit" class="btn-save" id="submit-bn" onClick="javascript:save('submit')"> Submit </button>&nbsp
		</div>
		
	</div>

</div>


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
			  alert("Please upload your revised design.");
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



</html>