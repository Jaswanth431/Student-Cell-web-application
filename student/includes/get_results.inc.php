<?php

  session_start();
  require_once('../../includes/db.php');

  if(isset($_POST['sem_type']) && isset($_POST['result_type'])){
    $id = $_SESSION['user'];
    $sem_type = $_POST['sem_type'];
    $result_type = $_POST['result_type'];

    //selecting student marks 
    $query = "SELECT * FROM ".$sem_type." WHERE clg_id=?";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare( $stmt, $query)){
      mysqli_stmt_bind_param($stmt,"s", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if(mysqli_num_rows($result) >0){
        echo "<script>error_display('',0)</script>";
        $sem = explode("__", $sem_type);
        if($result_type == "mid"){
          $output="<h1 class='secondary-heading table-caption'>".strtoupper($sem[0])." ".strtoupper($sem[1])." results</h1><table><tr><th class='left-align'>Subject</th><th>Sub Code</th><th>Credits</th><th>MID1</th><th>MID2</th><th>MID3</th><th>BO2</th></tr>";
          while($row = mysqli_fetch_assoc($result)){
            $mid1 = $row['mid1'];
            $mid2 = $row['mid2'];
            $mid3 = $row['mid3'];
            $bo2 = $row['BO2'];

            if($row['mid1']=="")$row['mid1']="-";
            if($row['mid2']=="")$row['mid2']="-";
            if($row['mid3']=="")$row['mid3']="-";
            if($row['BO2']=="")$row['BO2']="-";
            if($row['credits']=="")$row['credits']="-";

            if($bo2== ""){
              if($mid1=="" || $mid1 == "A" || $mid1 == "AB")$mid1=0;
              if($mid2=="" || $mid2 == "A" || $mid2 == "AB")$mid2=0;
              if($mid3=="" || $mid3 == "A" || $mid3 == "AB")$mid3=0;

              $mids = [$mid1,$mid2,$mid3];
              rsort($mids);
              $bo2 = (int)$mids[0] + (int)$mids[1];
            }else{
              $bo2 = (int)$row['BO2'];
            }

            $output.="<tr><td class='left-align'>".$row['subname']."</td><td>".$row['subcode']."</td><td>".$row['credits']."</td><td>".$row['mid1']."</td><td>".$row['mid2']."</td><td>".$row['mid3']."</td><td>".$bo2."</td></tr>  ";
          }

          $output.="</table>";
          echo $output;

        }else if($result_type == "wat"){

          $output="<h1 class='secondary-heading table-caption'>".strtoupper($sem[0])." ".strtoupper($sem[1])." results</h1><table><tr><th class='left-align'>Subject</th><th>Sub Code</th><th>Credits</th><th>WAT</th></tr>";
          while($row = mysqli_fetch_assoc($result)){
            if($row['wat']=="")$row['wat']="-";
            if($row['credits']=="")$row['credits']="-";

            $output.="<tr><td class='left-align'>".$row['subname']."</td><td>".$row['subcode']."</td><td>".$row['credits']."</td><td>".$row['wat']."</td></tr>  ";
          }

          $output.="</table>";
          echo $output;
        }else if($result_type == "sem"){
          $output="<h1 class='secondary-heading table-caption'>".strtoupper($sem[0])." ".strtoupper($sem[1])." results</h1><table><tr><th class='left-align'>Subject</th><th>Sub Code</th><th>Credits</th><th>Grade</th></tr>";
          while($row = mysqli_fetch_assoc($result)){
            if($row['grade']=="")$row['grade']="-";
            if($row['credits']=="")$row['credits']="-";

            $output.="<tr><td class='left-align'>".$row['subname']."</td><td>".$row['subcode']."</td><td>".$row['credits']."</td><td>".$row['grade']."</td></tr>  ";
          }

          $output.="</table>";
          
          //getting sgpa 
          $table = $sem[0]."__points";
          $query = "SELECT * FROM ".$table." WHERE clg_id='$id' AND sem_type='$sem[1]' ";
          $result = mysqli_query($conn, $query);

          if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $sgpa = $row['sgpa'];
          }else{
            $sgpa ="--";
          }
          $output.="<h1 class='sgpa'>SGPA: ".$sgpa."</h1>";
          echo $output;

        }else if($result_type == "compact_view"){
          $output="<h1 class='secondary-heading table-caption'>".strtoupper($sem[0])." ".strtoupper($sem[1])." results</h1><table><tr><th class='left-align'>Subject</th><th>Sub Code</th><th>Credits</th><th>MID1</th><th>MID2</th><th>MID3</th><th>BO2</th><th>WAT</th><th>Internal Marks</th><th>Grades</th></tr>";
          while($row = mysqli_fetch_assoc($result)){
            $mid1 = $row['mid1'];
            $mid2 = $row['mid2'];
            $mid3 = $row['mid3'];
            $wat= $row['wat'];
            $bo2 = $row['BO2'];

            if($row['mid1']=="")$row['mid1']="-";
            if($row['mid2']=="")$row['mid2']="-";
            if($row['mid3']=="")$row['mid3']="-";
            if($row['BO2']=="")$row['BO2']="-";
            if($row['wat']=="")$row['wat']="-";
            if($row['grade']=="")$row['grade']="-";
            if($row['credits']=="")$row['credits']="-";

            // $internal=10;
            if($bo2== ""){
              if($mid1=="" || $mid1 == "A" || $mid1 == "AB")$mid1=0;
              if($mid2=="" || $mid2 == "A" || $mid2 == "AB")$mid2=0;
              if($mid3=="" || $mid3 == "A" || $mid3 == "AB")$mid3=0;

              $mids = [$mid1,$mid2,$mid3];
              rsort($mids);
              $bo2 = (int)$mids[0] + (int)$mids[1];
            }else{
              $bo2 = (int)$row['BO2'];
            }
            $internal = (int)$bo2 + ($row['wat'] == ""?0:(int)$row['wat']);
            $output.="<tr><td class='left-align'>".$row['subname']."</td><td>".$row['subcode']."</td><td>".$row['credits']."</td><td>".$row['mid1']."</td><td>".$row['mid2']."</td><td>".$row['mid3']."</td><td>".$bo2."</td><td>".$row['wat']."</td><td>".$internal."</td><td>".$row['grade']."</td></tr>  ";
          }

          $output.="</table>";

          //getting sgpa 
          $table = $sem[0]."__points";
          $query = "SELECT * FROM ".$table." WHERE clg_id='$id' AND sem_type='$sem[1]' ";
          $result = mysqli_query($conn, $query);

          if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $sgpa = $row['sgpa'];
          }else{
            $sgpa ="--";
          }
          $output.="<h1 class='sgpa'>SGPA: ".$sgpa."</h1>";
          echo $output;
        }
      }else{
        echo "<script>error_display('No results found',1)</script>";
      }
    }
  }
?>
