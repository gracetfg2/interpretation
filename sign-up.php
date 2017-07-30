<?php
session_start();
//header('Location: sign-up-close.php');
 /************ Get Provider IP ****************/
 if(!$_SERVER['REMOTE_ADDR']){$ip="0";}
 else{  $ip=$_SERVER['REMOTE_ADDR'];}

 if(!$_SERVER['HTTP_X_FORWARDED_FOR']){ $proxy="0";}
 else{  $proxy=$_SERVER['HTTP_X_FORWARDED_FOR'];}

?>
<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Yu-Chun (Grace) Yen, UIUC">
    <link rel="icon" href="logo.png">
    <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Bootstrap core CSS and js -->
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>

    <!-- JQuery and Google font -->
    <link href='https://fonts.googleapis.com/css?family=Exo:100,400' rel='stylesheet' type='text/css'>

    <title> Sign Up Page </title>
    <?php include('webpage-utility/ele_header.php'); ?>
   

    <style>

        .centered-form{
            margin-top: 60px;
        }

        .centered-form .panel{
            background: rgba(255, 255, 255, 0.8);
            box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
        }
    </style>

</head>
<body>
	  <nav class="navbar navbar-inverse navbar-fixed-top" style="background:#002058">
      <div class="container">
        <div class="navbar-header" >
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php" style="color:#E87722">CRAFT</a>
        </div>

      </div>
    </nav>

	<div class="main-section">
		<div class="row centered-form">

        <!--<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">-->
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                        <h3>Sign Up for the Online Design Study &nbsp <small><!--[<a href="ProjectDescription.pdf" target="blank">Project Description</a>]--></small></h3>
                </div>
                
                        <div class="panel-body">

                             <p style="font-size:16px">In order to participate, you need to read this <a href="ConsentForm.pdf" target="_blank">consent form</a>, and confirm the following statement. Please print a copy of this consent form for your records, if you desire.</p>
          <div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            Please fill out or verify the indicated fields.
          </div>

          <form class="form-horizontal" name="signup" id="signup" method="post" action="signup_script.php"  enctype="multipart/form-data">
            
            <hr>
             
     <!--       <div class="form-group" id="form-group-file">
                <label for="fileToUpload" class="col-sm-4 control-label">Signed Page of the Consent Form<em>*</em></label>
                <div class="col-sm-8">
                      <input class="input-file" id="fileToUpload" name="fileToUpload" type="file" ><p class="help-block">Only PDF, JPG, JPEG, PNG, and GIF files are allowed, the image size should be less than 5MB</p>
                </div>

            </div>

-->
         <div class="form-group" id="form-group-consent">
            <div class="row" style="padding:20px">  
              <div class="col-sm-12" style="font-size:20px">   
                 <input type="checkbox" name="check-consent" id="check-consent">&nbsp I confirm that I have read the consent form and questions have been answered. I am 18 years of age or older and consent to participate in the study. 
              </div>
            </div>
          </div>


              <hr>

            <div class="form-group required" id="form-group-name">
                <label for="name" class="col-sm-4 control-label" >Your Name<em>*</em></label>
                <div class="col-sm-8">                
                  <input type="text" name="name" id="name" class="form-control input-sm" placeholder="e.g. John Smith">
                </div>
            </div>

            <div class="form-group required" id="form-group-age">
                <label for="age" class="col-sm-4 control-label" >Your Age<em>*</em></label>
                <div class="col-sm-8">                
                  <input type="text" name="age" id="age" class="form-control input-sm" placeholder="e.g. 23">
                </div>
            </div>
            
            <div class="form-group required" id="form-group-gender">
                <label for="gender" class="col-sm-4 control-label">Gender<em>*</em></label>
                    <div class="col-sm-8">
                            <label class="radio-inline">
                              <input type="radio" name="gender" id="female" value="female"> Female
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="gender" id="male" value="male"> Male
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="gender" id="other" value="other"> Other
                            </label>
                    </div>
            </div>

            <div class="form-group required" id="form-group-email" >
                <label for="email" class="col-sm-4 control-label" >Contact Email<em>*</em></label>
                <div class="col-sm-8">                
                  <input type="text" name="email" id="email"  class="form-control input-sm" placeholder="Contact Email Address" value=" ">
                   <p name="email-text" id="email-text" class="help-block"><em>This email address will be used to create an account and for all correspondence.</em></p>
                </div>
            </div>

            <div class="form-group required" id="form-group-paypal" >
                <label for="paypal" class="col-sm-4 control-label" >Paypal Address<em>*</em></label>
                <div class="col-sm-8">                
                  <input type="text" name="paypal" id="paypal"  class="form-control input-sm" placeholder="Your Paypal Account (e.g. mypaypal@gmail.com)" value=" ">
                   <p name="paypal-text" id="paypal-text" class="help-block"><em>This paypal address will be used to receive the compensation.</em></p>
                </div>
            </div>
<hr>
            

<!--            <div class="form-group required" id="form-group-expertise">
                <label for="expertise" class="col-sm-4 control-label">Your Design Expertise<em>*</em></label>
                    <div class="col-sm-8">
                            <label class="radio-inline">
                              <input type="radio" name="expertise" id="novice" value="novice"> No experienced whatsoever.
                            </label><br>
                            <label class="radio-inline">
                              <input type="radio" name="expertise" id="experienced" value="experienced"> Experienced
                            </label>
                    </div>
            </div>
-->
         <div class="form-group required" id="form-group-expertise">
            <label for="expertise" class="col-sm-4 control-label">Design Expertise<em>*</em></label>
                <div class="col-sm-8" >
                    <label class="radio-inline" style="text-align: left">
                      Novice
                      </label>
                        <label class="radio-inline" >
                        <input type="radio" name="expertise" id="expertise1" value="1">&nbsp
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="expertise" id="expertise2" value="2"> &nbsp
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="expertise" id="expertise3" value="3"> &nbsp
                      </label>
                       <label class="radio-inline">
                        <input type="radio" name="expertise" id="expertise4" value="4"> &nbsp
                      </label>
                       <label class="radio-inline">
                        <input type="radio" name="expertise" id="expertise5" value="5"> &nbspExperienced
                      </label>
                     <p name="email-text" id="email-text" class="help-block">Please self-report your design expertise.</p>
                </div>
        </div>
  <hr>
        <div class="form-group required" id="form-group-education">
            <label for="education" class="col-sm-4 control-label"> Design Education Background <em>*</em></label>
                <div class="col-sm-8" >
                       <label class="radio-inline" >
                        <input type="radio" name="education" id="education1" value="1">No background in design
                      </label><br>
                       <label class="radio-inline" >
                        <input type="radio" name="education" id="education2" value="2">Self-taught 
                      </label><br>
                       <label class="radio-inline" >
                        <input type="radio" name="education" id="education3" value="3">Some college-level design courses
                      </label><br>
                       <label class="radio-inline" >
                        <input type="radio" name="education" id="education4" value="4"> Associate degree
                      </label><br>
                      <label class="radio-inline" >
                        <input type="radio" name="education" id="education5" value="5"> Bechelor of Arts degree
                      </label><br>
                      <label class="radio-inline" >
                        <input type="radio" name="education" id="education6" value="6"> Master of Fine Arts degree
                      </label>
              </div>
        </div>

             <hr>

        <div class="form-group required" id="form-group-experience">
            <label for="experience" class="col-sm-4 control-label"> Years of Professional Experience in Design<em>*</em></label>
                <div class="col-sm-8" >
                       <label class="radio-inline" >
                        <input type="radio" name="experience" id="experience1" value="1">None
                      </label><br>
                       <label class="radio-inline" >
                        <input type="radio" name="experience" id="experience2" value="2">One year or less
                      </label><br>
                       <label class="radio-inline" >
                        <input type="radio" name="experience" id="experience3" value="3"> One to three years
                      </label><br>
                       <label class="radio-inline" >
                        <input type="radio" name="experience" id="experience4" value="4"> Three to five years
                      </label><br>
                          <label class="radio-inline" >
                        <input type="radio" name="experience" id="experience5" value="5"> More than five years
                      </label><br>
              </div>            
        </div>
<hr>
         <div class="form-group " >
                <label for="wherefrom" class="col-sm-4 control-label" >Where did you hear about the study? (Optional)</label>
                <div class="col-sm-8">                
                  <input type="text" name="wherefrom" id="wherefrom" class="form-control input-sm" placeholder="e.g. Reddit, Friend, Facebook, Email, Other..">
                </div>
            </div>

<input type="hidden" name="_source" id="_source" value="<?php echo  $ip;?>">
<input type="hidden" name="_proxy" id="_proxy" value="<?php echo  $proxy;?>">
               
               
    <hr>
              
            
        </form>

         <div class="form-group">
                    <div class="row"><div class="col-md-4"></div>
                    <div class="col-md-8">
                    <p ><button type="submit" class="btn btn-success btn-lg" style="width:200px" onClick="javascript:save()"> Sign Up </button> </p>

                   <p>If you already have an account, please <a href="index.php">sign in </a>here.</p></div></div>
                    </div>
                  </div>
                    </div>
                </div>
             </div>

              <?php include("webpage-utility/footer.php") ?>
          </div>
                 
                </div>
               </div>
            </div>
        </div>



	</div><!--end main-section-->





<script>

    isOkay = true;
    consent_ok = 0;
    isNewUser=0;
    ValidPaypal=0;

//Check Email Existence
  	document.getElementById('email').focusout = function(e){  	
      if ($('input#email').val() != "") {
        email_change();
      }

  	};

    document.getElementById('paypal').focusout = function(e){    
      if ($('input#paypal').val() != "") {
        paypal_change();
      }
    };
/*
//Check File Property
	 document.getElementById('fileToUpload').onchange = function(e){            
    test_file();
	};
*/

function test_file(){
      if (window.File && window.FileReader && window.FileList && window.Blob)
      { 
            $("#form-group-file").removeClass("has-error");
            $('#error_alert').hide();

            var fsize = $('#fileToUpload')[0].files[0].size;
            var ftype = $('#fileToUpload')[0].files[0].type;
            var fname = $('#fileToUpload')[0].files[0].name;

            //Check Size
            if(fsize>5242880) //do something if file size more than 5 mb (5242880)
            {
              consent_ok = 0;
              isOkay = false;
              alert("File: "+fname+" is too big! Your file should be less than 5 Mb. ");

              $("#form-group-file").addClass("has-error");
              $('#error_alert').show();
            }
            else //do something if file type is not pdf
            {
             
              switch(ftype){
                case 'application/pdf':
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/pjpeg':
                      consent_ok = 1;
                      break;
                default:
                    consent_ok = 0;
                    isOkay = false;
                    alert("Sorry, only PDF, JPG, JPEG, PNG, and GIF files are allowed.");
                    $("#form-group-file").addClass("has-error");
                    $('#error_alert').show();
                    break;
              
              }

             }
      }
      else{

         alert("Your broswer dosen't support file uploading, please use Google Chrome 6, Firefox 3.6, Safari 6 or IE 10+ versoin");

        $("#fileToUpload").attr("disabled", true);
      }

}
     
     jQuery(function() {

        $("#name").bind("keydown", function(){
          $('#error_alert').hide();
              $("#form-group-name").removeClass("has-error");
        });
        $("#age").bind("keydown", function(){
          $('#error_alert').hide();
              $("#form-group-age").removeClass("has-error");
        });

        $("#paypal").bind("keydown", function(){
          $('#error_alert').hide();
            $("#form-group-paypal").removeClass("has-success");
              $("#form-group-paypal").removeClass("has-error");
              $("#paypal-text").html("<em>This Paypal address will be used to receive the compensation.</em>");
        });

         $("#email").bind("keydown", function(){
            $('#error_alert').hide();
              $("#form-group-email").removeClass("has-success");
              $("#form-group-email").removeClass("has-error");
              $("#email-text").html("<em>This email address will be used to create an account and for all correspondence.</em>");
        });
        $("input[name='expertise']").bind("click", function(){
          $('#error_alert').hide();
            $('#form-group-expertise').removeClass("has-error");
        });
        $("input[name='gender']").bind("click", function(){
          $('#error_alert').hide();
            $('#form-group-gender').removeClass("has-error");
        });
        $("input[name='education']").bind("click", function(){
          $('#error_alert').hide();
            $('#form-group-education').removeClass("has-error");
        });
        $("input[name='experience']").bind("click", function(){
          $('#error_alert').hide();
            $('#form-group-experience').removeClass("has-error");
        });
               
	//$("#email").blur
      }); // jQuery(function(){})


function email_change() {
   
    $("#form-group-email").removeClass("has-error");
    $("#form-group-email").removeClass("has-success");
		$('#error_alert').hide();
   
    if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($.trim($('input#email').val())  ))) 
    {  
            isOkay = false; 
            $('input#email').parents('.form-group:first').addClass("has-error");
            $("#email-text").html("<em>Email address is invalid.</em>");   
                   
    }else{
        $.ajax({
        type: "POST",
            url:'email_exists.php',
            data: {email: $.trim($('input#email').val())},
            success: function (data) {
                switch(data)
                {
                  case "exists":
          //  alert("Email already exists in the system. Either use a different email or contact the administrator at yyen4@illinois.edu.");
                    $("#email-text").html("<em>Email is already taken.</em>");   
                    isNewUser = 0;
                    isOkay = false;
                    $('input#email').parents('.form-group:first').addClass("has-error");
                    $('#error_alert').show();
                    break;
                  case "success":
                      $("#form-group-email").addClass("has-success");
                      $("#email-text").html("<em>Valid Address. This email address will be used to create an account and for all correspondence.</em>");  
                    isNewUser = 1;
                    break;
                  default:

                     alert("Oops, our website encounters some problems. Please contact the system administrator at yyen4@illinois.edu");
                     alert(data);
                     isNewUser = 0;
                     isOkay = false;
                    break;
                }
            },
            error: function () {
            }
        });
    }


    
}



function paypal_change() {
   
    $("#form-group-paypal").removeClass("has-error");
    $("#form-group-paypal").removeClass("has-success");
    $('#error_alert').hide();
   
    if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($.trim($('input#paypal').val())  ))) 
    {  
            isOkay = false; 
            $('input#paypal').parents('.form-group:first').addClass("has-error");
            $("#paypal-text").html("<em>Paypal address is invalid.</em>");   
                   
    }else{
        $.ajax({
        type: "POST",
            url:'paypal_exist.php',
            data: {paypal: $.trim($('input#paypal').val())},
            success: function (data) {
                switch(data)
                {
                  case "exists":
          //  alert("Email already exists in the system. Either use a different email or contact the administrator at yyen4@illinois.edu.");
                    $("#paypal-text").html("<em>This Paypal address has been attached to another account. Please contact us if you want to share the Paypal address with others. </em>");   
                    ValidPaypal = 0;
                    isOkay = false;
                    $('input#paypal').parents('.form-group:first').addClass("has-error");
                    $('#error_alert').show();
                    break;
                  case "success":
                      $("#form-group-paypal").addClass("has-success");
                      $("#paypal-text").html("<em>Valid Address. This paypal address will be used to receive the compensation.</em>");  
                    ValidPaypal = 1;
                    break;
                  default:

                     alert("Oops, our website encounters some problems. Please contact the system administrator at yyen4@illinois.edu");
                     alert(data);
                     ValidPaypal = 0;
                     isOkay = false;
                    break;
                }
            },
            error: function () {
            }
        });
    }


    
}


     function save() {
          

        if (document.getElementById('check-consent').checked) {

          isOkay = true;
          $("#error_alert").hide();
          $(".has-error").removeClass("has-error");

        email_change();
        paypal_change();
        
        if(isNewUser == 0){
           isOkay = false;
      		$('input#email').parents('.form-group:first').addClass("has-error");
        }

        if(ValidPaypal == 0){
           isOkay = false;
          $('input#paypal').parents('.form-group:first').addClass("has-error");
        }
/*
      	if(consent_ok == 0){
      		isOkay = false;
          $("#form-group-file").addClass("has-error");
		
      	}
*/
        
      

        $('input#name').val($.trim($('input#name').val() )  );        
        if ($('input#name').val() == "") {
             $('input#name').parents('.form-group:first').addClass("has-error");
              isOkay = false;
        }

        $('input#paypal').val($.trim($('input#paypal').val() )  );        
           if ($('input#paypal').val() == "") {
             $('input#paypal').parents('.form-group:first').addClass("has-error");
              isOkay = false;
        }
        
        $('input#email').val($.trim($('input#email').val() )  );        
        if ($('input#email').val() == "") {
             $('input#email').parents('.form-group:first').addClass("has-error");
              isOkay = false;
        } //check email address

        $('input#age').val($.trim($('input#age').val() )  );        
        if ($('input#age').val() == "") {
             $('input#age').parents('.form-group:first').addClass("has-error");
              isOkay = false;
        }

        if ($("input[name='expertise']:checked").size() == 0 ) {
              $("#form-group-expertise").addClass("has-error");
              isOkay = false;
        }

        if ($("input[name='gender']:checked").size() == 0 ) {
              $("#form-group-gender").addClass("has-error");
              isOkay = false;
        }


        if ($("input[name='experience']:checked").size() == 0 ) {
              $("#form-group-experience").addClass("has-error");
              isOkay = false;
        }


        if ($("input[name='education']:checked").size() == 0 ) {
              $("#form-group-education").addClass("has-error");
              isOkay = false;
        }
/*
        if ( document.getElementById("fileToUpload").value == "") {
             $("#form-group-file").addClass("has-error");
              isOkay = false;
         }else{
          test_file();
         }
*/

        
           if(isOkay==true)//Everything went through
          {                
            $('#signup').submit();
          }
          else{
            $("#error_alert").show();
          }
  
        
        }
        else{
          alert("You need to read the consent form and consent to participate!");
           isOkay = false;
            $("#form-group-consent").addClass("has-error");
          
        }
    
  } 


</script>


</body>
</html>


