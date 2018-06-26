<?php
session_start();
if(isset($_SESSION['timer'])){
    $now = time();
    $timeSince = $now - $_SESSION['timer'];
    $_SESSION['time_passed'] = $timeSince/60;

    if($_SESSION['limit']<=$timeSince && (!isset($_SESSION['freezeExams']) || (isset($_SESSION['freezeExams']) && !$_SESSION['freezeExams']))) {
      $_SESSION['freezeExams'] = true;
      echo "<script>window.top.location.href = \"http://localhost/evaluation_ISGA/public/student/myExams.php\";</script>";
    }
  }
 ?>
