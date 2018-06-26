<?php
session_start();
if(isset($_SESSION['timer'])){
    $now = time();
    $timeSince = $now - $_SESSION['timer'];
    $_SESSION['time_passed'] = $timeSince/60;

    if($_SESSION['limit']<$timeSince)
        header('location: myExams.php');
}
 ?>
