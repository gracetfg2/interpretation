<?php 
	session_start();		
    $providerName = 'grace';
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');

?>
<html lang="en">
<head>
<title>Review Feedback </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_header.php');?>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<style>
    .box {
        border: 2px solid black;
        padding: 5px;
        margin: 5px;
    }

    .pagination  li{   
    cursor: pointer;
}
.pagination .finish a{
    background-color: #ccffcc;
  
    color:#336600;
}

.pagination li.active a{
    background-color: rgb(51,122,183);

    color: white;
}


.pagination .incomplete a{
    background-color: #ffcccc;

     color:#993333;
}
.tablelabel{
    font-weight: bold;
    font-size:16px;
    color:#154360;
}
</style>
</head>
    
<body>
 
<div class="container"> 
 <div class='well' style='padding: 20px'>  
    Below is a list of data we collected from our experiment. In the first column, you can see a graphic design addressing the design brief. In the second column, you can see a piece of feedback given to the design (first column). <b>The designer was asked to restate the content of the feedback (second column) using their own words, and the response(third column) should cover all the content and keep the feedback's original meaning. </b><br><br>

    Your task is to read the feedback (second column) and the designer's response to the feedback (third column), and decide the quality of the response from low (1) to high (5). You may use the following rubrics for this task. 
    <br><br>
 
    - 1  : The response was not restating the meaning of the feedback. See #124 <br>
    - 2 : The response restated some points in the feedback, but missed a majority of the content in the feedback. See #1<br>
    - 3 : The response restated almost a half of the critical points in the feedback. See #10<br>
    - 4 : The response restated a majority but not all of the critical points in the feedback. <br>
    - 5 : The response restated all the critical points in the feedback. See #3 and #5.<br>
    

    
</div>
<hr>
<div class='row'>
    <strong>
        <div class='col-md-1'>#</div>
        
        <div class='col-md-3'>Design Image</div>
        <div class='col-md-5'>Feedback</div>
        <div class='col-md-3'>Designer's Restatement of the feedback</div>
    </strong>
</div>
<hr>
<?php
        $feedback = array();
        $results = array();

        if ($stmt = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID` > 26 AND `ok_to_use` = 1")) {
            mysqli_stmt_bind_param($stmt, "s", $providerName);
            mysqli_stmt_execute($stmt);
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                array_push($feedback, $row);
            }
        }
        
        $count=0;

        foreach($feedback as $entry) {
            $designID = $entry['f_DesignID'];        
            $image = "";
            if ($stmt = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `DesignID`=?")) {
                mysqli_stmt_bind_param($stmt, "i", $designID);
                mysqli_stmt_execute($stmt);
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $image = $row['file'];
                }
            }
            else {
                echo "Image query prepare failed: (" . $conn->errno . ") " . $conn->error;
            }

            if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `ResponseRating` WHERE `raterID`=? AND `f_FeedbackID`=?")) {
                mysqli_stmt_bind_param($stmt2, "si",$providerName,  $entry['FeedbackID']);
                mysqli_stmt_execute($stmt2);
                $result_rating = $stmt2->get_result();
                while ($row = $result_rating->fetch_assoc()) {
                   $response_quality= $row['rating'];
                }
            }else {
                echo "Response Rating query prepare failed: (" . $conn->errno . ") " . $conn->error;
            }

            $feedbackContent = $entry['edited_content'];
            $feedbackRating = $entry['designer_rating'];
            $response = $entry['interpretation'];
            $f_id = $entry['FeedbackID'];
            $provider = $entry['f_ProviderID'];
            $imagePath = "/interpretation/design/". $image;

            if($response !=null){
                   
                    array_push( $results, $f_id);
                    $count++;
                   
            echo "<div id='p".$f_id."' class='pagecontent' style='display:none'>";
            
            echo "   
                    <div class='row'>
                        <div class='col-md-1'>#".$count."</div>
                            <div class='col-md-3'><img width='200px' border=\"2\" src=\"". $imagePath ."\" class=\"img-responsive\"></div>
                            <div class='col-md-5'><p>".  $feedbackContent."</p></div>
                            <div class='col-md-3'><p>". $response ."</p></div>

                        </div>
                       <div class='row' style='margin-top:20px; margin-left:30px'> ";

            echo "<h4> Please rate the quality of the designer's restating of the feedback:</h4>
            
           <table>
                <tr>
                <td>
                    <table style='width:600px;text-align:center;' border='0' cellpadding='5' cellspacing='0'>
                        <tr aria-hidden='true'>
                            <td  class='radio-label'></td>
                            <td><label class='radio-cell'>1</label></td> 
                            <td><label class='radio-cell'>2</label></td> 
                            <td><label class='radio-cell'>3</label></td> 
                            <td><label class='radio-cell'>4</label></td>
                            <td><label class='radio-cell'>5</label></td> 
                            <td  class='radio-label' ></td>
                        </tr>
                
                        <tr>
                            <td class='radio-label' width='150px'><strong>Low</strong></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='response".$f_id."' id='".$f_id."1'  value='1' "; if ($response_quality==1){echo "checked ";} echo "onclick='rate(".$f_id.",1);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='response".$f_id."' id='".$f_id."2'  value='2' "; if ($response_quality==2){echo "checked ";} echo "onclick='rate(".$f_id.",2);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='response".$f_id."' id='".$f_id."3'  value='3' "; if ($response_quality==3){echo "checked ";} echo "onclick='rate(".$f_id.",3);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='response".$f_id."' id='".$f_id."4'  value='4' "; if ($response_quality==4){echo "checked ";} echo "onclick='rate(".$f_id.",4);'></td>
                            <td class='radio-cell'><input type='radio' class='radio-inline' name='response".$f_id."' id='".$f_id."5'  value='5' "; if ($response_quality==5){echo "checked ";} echo "onclick='rate(".$f_id.",5);'></td>
                            <td class='radio-label' width='200px'><strong>High</strong></td>      
                        </tr>

                    </table>
                </td>
                </tr>
            </table>



                       </div>
                        <hr>
                        </div>";


            }

            //array_push($results, [$imagePath, $feedbackContent, $feedbackRating,$response, $f_id, $provider]);
            //echo "<img src=\"". $imagePath ."\">\n";
            //echo $feedbackText;
        }

        CloseConnection_Util($conn);
        ?>

<input type='hidden' name='provider' id='provider' value='<?php  echo $providerName; ?>'>
<div style='padding-top:20px'></div>
<nav>
  <ul class="pagination">
    

     <?php 
        $index=1;
        foreach($results as $value)
        {
            $current_class='indicator incomplete';

            //Both not selected
            if( !$value['response_quality'] ) $current_class='indicator';
            //Both selected
            if( $value['response_quality'])$current_class='indicator finish';

            echo " <li class='".$current_class."' id='li".$value."' name='li".$value."'><a onclick='showUI(".$value.")';>".$index."</a></li>";
            $index++;
        }
    ?>

  </ul>
</nav>
<div id='check-result' name='check-result'> </div>
</div>
<script>
    function showUI(_id){
        $('#check-result').html();  

        $('.indicator').removeClass('active');
        
        $('#li'+_id).addClass('active');
        $('.pagecontent').hide();
        $('#p'+_id).show();         
    }


    function rate(_idx, number){
    
        $.ajax({
            type: "POST",
            url:'save_response_rating.php',
            data: {feedbackid: _idx ,action:'update_rating',  selected: number , provider: $('#provider').value },
            success: function (data) {

                $('#li'+_idx).removeClass('active');
                $('#li'+_idx).removeClass('incomplete');    
                $('#check-result').html('Rating is saved!');         
                if ($('input[name=response'+_idx+']:checked').size() == 0 )
                {               
                    $('#li'+_idx).addClass('incomplete');
                    $('#li'+_idx).addClass('active');

                }
                else
                {
                    $('#li'+_idx).addClass('finish');
                    //$('#li'+_idx).addClass('active');
                    if(!$('#li'+_idx).is(':last-child'))
                    {
                        $('#li'+_idx).next().addClass('active');
                        $('#check-result').html();  
                        $('.pagecontent').hide();
                        $('#p'+_idx).next().show();

                    }
                    else
                    {
                        $('#li'+_idx).addClass('active');
                        $('#check-result').html('Selection saved! This is the last project!');
                    }
                    
                }
                        
            },
            error: function () {
            }

    
        });
    }

</script>

</body>

</html>
