<?php 

  include_once('general_information.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>UIUC Design Study</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container" style="padding-top:20px">




      <!-- Main component for a primary marketing message or call to action -->
<div class="jumbotron" style="margin-top:20px; padding-top:20px;background:white;margin-left:0px">
<div><img src="school_logo.gif"></div>
<br>
        <h1 ><span style="font-size:42px;">Online Design Study</span></h1>

        <h3>Be Creative. Design a Flyer. </h3>
        <p>We are researchers at the University of Illinois investigating how designer use online feedback to iterate on their creative work. In this study, you will need to create a flyer design for a jazz concert, perform an assigned activity, and revise the design. All designs and data collected in this study are for research purposes only.</p>
        <p>  We do not require design background, but your design should meet certain criteria and has adequate quality to be considered in the study. We list designs in our last study when we asked for a flyer design for a half marathon event.
        </p>
         
         <table style="border-spacing: 30px;">
   <tr>
   
<?php
    $files = glob('samples/*.*'); // assuming images are stored in directory called "images"
    foreach($files as $file) {
        echo "<td><img width='200px' height='250px' src='".$file."' /></td><td width='10px'></td>";
    }
?>
          </tr>

         </table>
<hr>
         <h3>Procedure and Deadlines</h3>
         <p>​The study has two phases. In the first phase, you will need to submit your
initial design for the event. In the second phase, you will perform the activity assigned to you, revise your initial design and complete a survey. All the activities are conducted online.</p>

<p>
<ul style='font-size: 18px'> 
<li>Deadline for the first phase: <span style='color:red'> <?php echo $first_deadline; ?></span>. </li>
<li>Deadline for the second phase: Two days after you complete the first stage of the study. </li>
</ul>
</p>
<p>Please check your schedule before signing up.</p>


         <h3>Compensation and prizes:  </h3>
         <p>​We will provide $25 for full participation. The top 5 (out of
60) designs will receive a bonus of $20 US dollars. All compensation will be distributed
via Paypal, so you will need to provide a Paypal address if you want to receive the
compensation.</p>

         <h3>Selection Criteria:  </h3>
         <p>
        (1)​ You must be at least 18 years of age.<br>
        (2) You must allow us to maintain a copy of your design and feedback for research
        purposes.
        </p>



       
       
      
        </p>
<hr>
<h3>Contact Us </h3>
<p>
The study has been approved by the University of Illinois Institutional Review Board. If you have questions, please contact our research staff Grace Yen at design4uiuc@gmail.com, or click <strong>Next</strong> to sign up.
</p>

          <a class="btn btn-lg btn-primary" href="sign-up.php" role="button">Next &raquo;</a>
        </p>
</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>
