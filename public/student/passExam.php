<?php include "../templates/header.php"; ?>

<?php include "../shared/studentnavbar.php"; ?>
<?php
require_once '../../connection.php';
    if(!isset($_SESSION['timer'])){
        $_SESSION['timer'] = time();
        $_SESSION['time_passed'] = 0;
    }

  try  {
    $sql = "SELECT exams.duree, exams.date, CONCAT(users.firstName ,' ', users.lastName) as owner, typeExam.name as type
    FROM exams
        INNER JOIN users ON users.id = exams.userId
        INNER JOIN typeExam ON typeExam.id = exams.typeExamId
    WHERE exams.id = '".$_GET['exam']."'";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $examobject = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['limit'] = $examobject["duree"]*60;
    $_SESSION['currentexam'] = $_GET['exam'];

  $sqlQuestions = "SELECT questions.id, questions.contenue as contenue, reponse.id as reponseid, reponse.contenue as reponsecontent
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
          "id" => $value['id'],
          "question" => $value['contenue'],
          "responses" => array()
        );
        $id = $value["id"];
      }
      array_push($finalquestion['responses'], array("reponsecontent"=> $value['reponsecontent'], "id" => $value['reponseid']));
    }
      array_push($finalArray, $finalquestion);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }



  if (isset($_POST['submit'])) {

        try  {
          $new_passing = array(
            "examId" => $_GET['exam'],
            "userId" => $_SESSION['id'],
            "date"     => date("Y-m-d H:i:s")
          );

          $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "etudExam",
            implode(", ", array_keys($new_passing)),
            ":" . implode(", :", array_keys($new_passing))
          );

          $statementpassing = $connection->prepare($sql);
          $statementpassing->execute($new_passing);
          $etudExamId = $connection->lastInsertId();
          try  {
            foreach($finalArray as $row){
              foreach($row['responses'] as $responserow){
                if(isset($_POST['question'.$row['id'].$responserow['id']]) && $_POST['question'.$row['id'].$responserow['id']] == 'on') {


                    $new_reponse = array(
                      "etudexamId" => $etudExamId,
                      "questionId" => $row['id'],
                      "reponseId"  => $responserow['id']
                    );

                    $sqlreponse = sprintf(
                      "INSERT INTO %s (%s) values (%s)",
                      "etudExamReponse",
                      implode(", ", array_keys($new_reponse)),
                      ":" . implode(", :", array_keys($new_reponse))
                    );

                    $statementreponse = $connection->prepare($sqlreponse);
                    $statementreponse->execute($new_reponse);

                }
              }
            }
            unset($_SESSION['timer']);
            unset($_SESSION['limit']);
            unset($_SESSION['currentexam']);
            unset($_SESSION['time_passed']);
            unset($_SESSION['freezeExams']);
            
            header('location: myExams.php');

          } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
          }

        } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }
  }

?>
<div id="countdowntimer">
</div>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card card-body bg-light mt-5">

          <form method="post" id="reponseform">

            <div class="row">
              <div class="col-md-10">
                <h2> Examen (<?php echo $examobject['duree'] ?>min) <small> Veulliez selectionnez la/les réponses correct ( Temps passée : <span id="passedtime"></span> Min)</small></h2>
              </div>
              <div class="col-md-2">
              <input class="btn btn-success pull-right" id="reponseformsubmit" type="submit" name="submit" value="C'est fini">
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
                          if(isset($_SESSION['freezeExams']) && $_SESSION['freezeExams'])
                            echo "<label><input disabled type=\"checkbox\" name='question".$row['id'].$responserow['id']."'>".$responserow['reponsecontent']."</label>";
                          else
                           echo "<label><input type=\"checkbox\" name='question".$row['id'].$responserow['id']."'>".$responserow['reponsecontent']."</label>";
                        }
                        echo "</div>";
                     }
                     ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              </table>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <script>
      $(document).ready(function(){
          $("#countdowntimer").load("countdown.php");
          $("#passedtime").load("passedtime.php");
          setInterval(function() {
              $("#countdowntimer").load("countdown.php");
              $("#passedtime").load("passedtime.php");
          }, 10000);
      });

  </script>
<?php include "../templates/footer.php";?>
