<?php include "../templates/header.php"; ?>

<?php include "../shared/studentnavbar.php"; ?>
<?php

require_once '../../connection.php';

  try  {
    $sql = "SELECT exams.date, CONCAT(users.firstName ,' ', users.lastName) as owner, typeExam.name as type
    FROM exams
        INNER JOIN users ON users.id = exams.userId
        INNER JOIN typeExam ON typeExam.id = exams.typeExamId
    WHERE exams.id = '".$_GET['exam']."'";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $examobject = $statement->fetch(PDO::FETCH_ASSOC);

  $sqlQuestions = "SELECT questions.id, questions.contenue as contenue, reponse.contenue as reponsecontent
  FROM questions
    INNER JOIN examquestions ON questions.id = examquestions.questionid
    INNER JOIN reponse ON questions.id = reponse.questionid
    WHERE examquestions.examid = ".$_GET['exam'];
    $statementQuestions = $connection->prepare($sqlQuestions);
    $statementQuestions->execute();

    $result = $statementQuestions->fetchAll();

    $finalArray = array();
    $id = null;
    foreach ($result as $value) {
      if($id != $value["id"]) {
        if($id != null) {
          array_push($finalArray, $finalquestion);
        }
        $finalquestion = array(
          "question" => $value['contenue'],
          "responses" => array()
        );
        $id = $value["id"];
      }
      array_push($finalquestion['responses'], $value['reponsecontent']);
    }
      array_push($finalArray, $finalquestion);
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
              <h2> Examen <?php echo $examobject['date'] ?> <small> Veulliez selectionnez la/les réponses correct </small></h2>
            </div>
            <div class="col-md-2">
              <a class="btn btn-success pull-right">C'est fini</a>
            </div>
          </div>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td class="col-md-8">Question</td>
                <td class="col-md-4">Choix</td>
              </tr>

              <?php foreach ($finalArray as $row) : ?>
              <tr>
                <td> <?php echo $row["question"]; ?> </td>
                <td>
                  <?php
                   if(count($row['responses'])){
                      echo "<div class=\"checkbox\">";
                      foreach($row['responses'] as $responserow){
                         echo "<label><input type=\"checkbox\">$responserow</label>";
                      }
                      echo "</div>";
                   }
                   ?>
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
