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

<style>
.fig-cap{
  text-align: center;
}
</style>
</head>

  <body>

    <div class="container" style="padding-top:20px">

<nav class="navbar navbar-fixed-top navbar-inverse" style="background:#EBF5FB  ">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:#E87722" href="index.php"><img width='150px' src="school_logo.gif"></a>
            </div>
         
        </div>
      
  </nav>


      <!-- Main component for a primary marketing message or call to action -->
<div class="jumbotron" style="margin-top:20px; padding-top:20px;background:white;margin-left:0px">
<div></div>
<br>
  <h2 style="text-align:center;"><span> Online Design Research</span></h2>
  <h3>Be Creative. No Design Experience Required.</h3>
    <p>We are investigating how a user incorporates online feedback into an iterative design process. In this study, you will practice creating a flyer for a charity event featuring the American singer-songwriter, <a href='https://www.youtube.com/user/taylorswift' target="_blank">Taylor Swift</a>. All designs and data collected in this study are for research purposes only. The total time commitment will be around 2.5 hours (including design sessions) split between separate days. All the activities are conducted online.</p>
<hr>

<h3>Compensation and prizes:  </h3>
      <p>​We will provide <strong>$30</strong> for full participation. The final top 10 designs will receive a bonus of <strong>$20 </strong>US dollars. All compensation will be distributed via Paypal, so you will need to provide a Paypal address if you want to receive the compensation.</p>
<hr>
  <h3>Selection Criteria:  </h3>           
    <p> 
      <ul style='font-size: 18px'> 
      <li>You must be at least 18 years of age.</li>
      <li>You must have a strong desire to create a flyer addressing the design brief.</li>
      <li>You must be willing to incorporate online feedback into the design process.</li>
      <li>You must allow us to keep a copy of your design and feedback for research purposes.</li>
      </ul>
  </p>       
<hr>

<h3>Procedure and Deadlines</h3>
<p>​The study has two phases. In the first phase, you will create and submit your
initial design addressing our design brief. We hire two professional designers to provide feedback on your initial design. In the second phase, our platform will step you through the revision process. All the activities are conducted online.</p>
<p>
<ul style='font-size: 18px'> 
<li>Deadline for the first phase: <span style='color:red'> <?php echo $first_deadline; ?></span>. </li>
<li>Deadline for the second phase: Three days after you complete the first stage of the study. </li>
</ul>
</p>
<p>Please check your schedule before signing up.</p>

<hr>
  
<h3>About Us</h3>  
    <p>We are researchers passionate about building and studying technologies that influence design, creativity, and innovation processes. For more information, please visit our websites. </p>
    
  <div class="row">
  <p>
  <figure class="col-md-3"><img src="grace.jpg" class="img-circle" width="200" height="200">  
    <figcaption style='text-align: center;' class="fig-cap">
      <strong><a href='https://www.linkedin.com/in/yu-chun-grace-yen-1a278a6a/' target='_blank'>Grace Y. Yen </a></strong><br>PhD Candidate<br>Computer Science<br>UIUC</figcaption></figure>
   <figure class="col-md-3"><img src="brian.jpg" class="img-circle" width="200" height="200">  <figcaption class="fig-cap"><strong><a href="http://orchid.cs.illinois.edu/publications/index.html">Dr. Brian Bailey</a></strong><br>Professor<br>Computer Science<br>UIUC</figcaption></figure>
     <figure class="col-md-3"><img src="steven.jpg" class="img-circle" width="200" height="200">  <figcaption class="fig-cap"><strong><a href='http://spdow.ucsd.edu/' target='_blank'>Dr. Steven Dow</a></strong><br>Assistant Professor<br>Computer Science<br>UCSD</figcaption></figure>
       <figure class="col-md-3"><img src="liz.jpg" class="img-circle" width="200" height="200">  <figcaption class="fig-cap"><strong><a href='https://egerber.mech.northwestern.edu/'>Dr. Liz Gerber</a></strong><br>Associate Professor<br> Design <br>Northwestern University</figcaption></figure>
     </p>
  </div>
<hr> 


<h3>Contact Us </h3>
<p>
The study has been approved by the University of Illinois Institutional Review Board. If you have questions, please contact our research staff Grace Yen at <a href="mailto:design4uiuc@gmail.com">design4uiuc@gmail.com</a>  
or click <strong>Sign Up</strong> to begin the study.
</p>

<a class="btn btn-lg btn-primary" href="sign-up.php" role="button">Sign Up</a>
  <a class="btn btn-lg btn-success" href="index.php" role="button"> Log In</a>
</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
  </body>
</html>
