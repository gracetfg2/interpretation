<?php
session_start();
$_SESSION['admin']='gracesnehabrian';

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM monitorbehavior ORDER BY explain_useful ASC")) {
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          while ($myrow = $result->fetch_assoc()) {
            $designer[]=$myrow;

          }

  mysqli_stmt_close($stmt2);
}
else {
//No Designers found
  echo "Our system has no designers yet";
  mysqli_stmt_close($stmt2);
  die();
}



?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <form name='control-form' id='control-form' action='control_panel_script.php' method='post'>
    <table border="1" style="text-align:center; " >
      <tr>
     
      <th>Confidence 1</th>
      <th>Confidence 2</th>
      <th>Quality 1</th>
      <th>Quality 2</th>

      <th>Degree of Change </th>
      <th>Rewrite Usefulness </th>
      <th>Reflection Usefulness </th>

      <th>Explanation Time </th>
      <th> Reflection Time </th>

      <th>Task Difference </th>
      <th>Explain Rewrite </th>
      <th>Explain Reflection </th>
      <th>Explain Difference </th>



      </tr>

      <?php
        foreach($designer as $bdata)
        {

          if ($stmt3 = mysqli_prepare($conn, "SELECT * FROM BehaviorGlobal WHERE DesignerID=?")) {
            mysqli_stmt_bind_param($stmt3, "i", $bdata['f_DesignerID']);
            mysqli_stmt_execute($stmt3);
            $result = $stmt3->get_result();
            $behavior = $result->fetch_assoc();
          }




          if( $bdata['explain_difference']!=null){
          echo "<tr>";

          echo "<td>".$bdata['confidence_1']."</td>";
          echo "<td>".$bdata['confidence_2']."</td>";         
          echo "<td>".$bdata['quality_1']."</td>";
          echo "<td>".$bdata['quality_2']."</td>";
          echo "<td>".$bdata['degreeOfChange']."</td>";
          echo "<td>".$bdata['explain_useful']."</td>";
          echo "<td>".$bdata['reflection_useful']."</td>";
          echo "<td>".$bdata['difference_rating']."</td>";

          echo "<td>".$behavior['total_interpretation']."</td>";
          echo "<td>".$behavior['total_reflection']."</td>";
 
          echo "<td>".$bdata['explain_selfexplain']."</td>";
          echo "<td>".$bdata['explain_reflectionuse']."</td>";
          echo "<td>".$bdata['explain_difference']."</td>";

         
          echo "</tr>";

          }
         


        }
      ?>



    </table>


  </form>

 
<script>
 function submit(){
   document.getElementById("control-form").submit();
  //  $("#control-form").submit();
 }

 //function rate() This is an alternative to save ratings
</script>

</body>
</html>
