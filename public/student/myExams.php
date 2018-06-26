<?php include "../templates/header.php"; ?>

<?php include "../shared/studentnavbar.php"; ?>
<?php

require_once '../../connection.php';

unset($_SESSION['timer']);
unset($_SESSION['limit']);
unset($_SESSION['time_passed']);

  try  {
    $sql = "SELECT COUNT(examquestions.questionId) as totalquestion, exams.id as examid, exams.date, CONCAT(users.firstName ,' ', users.lastName) as owner, typeExam.name as type
    FROM exams
        INNER JOIN users ON users.id = exams.userId
        INNER JOIN typeExam ON typeExam.id = exams.typeExamId
        INNER JOIN examquestions ON exams.id = examquestions.examId
    GROUP BY examquestions.examId";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    $finalResult = array();
    foreach ($result as $exam) {
      $sql = "SELECT *
              FROM etudExam
              INNER JOIN etudExamReponse on etudExamReponse.etudexamId = etudExam.id
              INNER JOIN reponse on etudExamReponse.reponseId = reponse.id
              WHERE etudExam.examId =".$exam['examid']." AND etudExam.userId = ".$_SESSION['id'];
      $statement = $connection->prepare($sql);
      $statement->execute();
      $resultResponses = $statement->fetchAll();
      $score = 0;
      $correct = 0;
      $total = 0;
      foreach ($resultResponses as $response) {
        $total++;
        if($response['correct'] == 1)
        $correct++;
      }
      $score = $total > 0 ? $correct/$exam['totalquestion']*100 : 0;
      array_push($finalResult, array("data"=> $exam, "score" => $score, "total" => $total));

    }
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
?>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card card-body bg-light mt-5">
          <div class="row">
            <div class="col-md-10">
              <h2>Mes Exams</h2>
            </div>
          </div>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td>Propriétaire</td>
                <td>Type</td>
                <td>Nombre de Question</td>
                <td>Date expiration</td>
                <td>Score/Action</td>
              </tr>

              <?php foreach ($finalResult as $row) : ?>
              <tr>
                <td><?php echo $row["data"]["owner"]; ?></td>
                <td><?php echo $row["data"]["type"]; ?></td>
                <td><?php echo $row["data"]["totalquestion"] ?></td>
                <td><?php echo $row["data"]["date"]; ?></td>
                <td>
                  <?php if($row['total'] > 0) echo $row["score"]; else echo '<a class="btn btn-success pull-right" style="margin: 0 5px;" href="/evaluation_ISGA/public/student/passExam.php?exam='.$row["data"]["examid"].'" >Passer l\'Examen</a>'; ?>

                </td>
              </tr>
            <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include "../templates/footer.php"; ?>
