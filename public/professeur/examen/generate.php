
<?php require "../../templates/header.php"; ?>

<?php include "../../shared/publicnavbar.php"; ?>
<?php
 require_once '../../../connection.php';


 $password_err = $confirm_password_err = '';

if (isset($_POST['submit'])) {
      try  {

      $questionslimit = $_POST['questionsNombres']*$_POST['variants'];

      $sqlQuestion = "SELECT * FROM questions
      INNER JOIN questionModules ON questionModules.questionId = questions.id
      INNER JOIN modules ON modules.id = questionModules.moduleId
      INNER JOIN userModules ON userModules.moduleId = modules.id

      INNER JOIN questionNiveaux ON questionNiveaux.questionId = questions.id
      INNER JOIN niveaux ON niveaux.id = questionNiveaux.niveauId
      INNER JOIN userNiveaux ON userNiveaux.niveauId = niveaux.id

      INNER JOIN questionFilieres ON questionFilieres.questionId = questions.id
      INNER JOIN filieres ON filieres.id = questionFilieres.filiereId
      INNER JOIN userFilieres ON userFilieres.filiereId = filieres.id

      WHERE userFilieres.userId = ".$_SESSION['id']." AND userNiveaux.userId = ".$_SESSION['id']." AND userModules.userId = ".$_SESSION['id']."

      LIMIT ".$questionslimit;
      $statementQuestion = $connection->prepare($sqlQuestion);
      $statementQuestion->execute();

      $questionList = $statementQuestion->fetchAll();

      for ($i=0; $i < $_POST['variants']; $i++) {

        $usedQuestion = array();

        $new_user = array(
          "typeExamId" => $_POST['typeExamId'],
          "duree" => $_POST['duree'],
          "userId" => $_SESSION['id'],
          "date"     => date("Y-m-d H:i:s")
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "exams",
          implode(", ", array_keys($new_user)),
          ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
        $examid = $connection->lastInsertId();

        for ($j=0; $j < $_POST['questionsNombres'] && $j< count($questionList); $j++) {
          $questionIndex = rand(0,count($questionList)-1);
          if (!in_array($questionIndex, $usedQuestion)) {
            $questionexam = array(
              "examId" => $examid,
              "questionId" => $questionList[$questionIndex]['id']
            );

            $sqlquestionexam = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "examQuestions",
              implode(", ", array_keys($questionexam)),
              ":" . implode(", :", array_keys($questionexam))
            );

            $statementquestionexam = $connection->prepare($sqlquestionexam);
            $statementquestionexam->execute($questionexam);
            array_push($usedQuestion, $questionIndex);
          } else {
            $j--;
          }
        }

        foreach ($_POST['niveaux'] as $selectedOption) {
            $new_userniveaux = array(
              "examId" => $examid,
              "niveauId" => $selectedOption
            );
            $sql = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "examsNiveaux",
              implode(", ", array_keys($new_userniveaux)),
              ":" . implode(", :", array_keys($new_userniveaux))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_userniveaux);
        }
        foreach ($_POST['filieres'] as $selectedOption) {
            $new_userfilliere = array(
              "examId" => $examid,
              "filiereId" => $selectedOption
            );
            $sql = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "examsFilieres",
              implode(", ", array_keys($new_userfilliere)),
              ":" . implode(", :", array_keys($new_userfilliere))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_userfilliere);
        }
        foreach ($_POST['modules'] as $selectedOption) {
            $new_usermodule = array(
              "examId" => $examid,
              "moduleId" => $selectedOption
            );
            $sql = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "examsModules",
              implode(", ", array_keys($new_usermodule)),
              ":" . implode(", :", array_keys($new_usermodule))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_usermodule);
        }

      }

          header('location: list.php');
        } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }
}


  try  {
    $sql = "SELECT * FROM typeexam";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try  {
    $sql = "SELECT * FROM filieres INNER JOIN userFilieres on userFilieres.filiereId = filieres.id WHERE userFilieres.userId = ".$_SESSION['id'];
    $statement = $connection->prepare($sql);
    $statement->execute();

    $filliers = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try  {
    $sql = "SELECT * FROM modules INNER JOIN userModules on userModules.moduleId = modules.id WHERE userModules.userId = ".$_SESSION['id'];
    $statement = $connection->prepare($sql);
    $statement->execute();

    $modules = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try  {
    $sql = "SELECT * FROM niveaux INNER JOIN userNiveaux on userNiveaux.niveauId = niveaux.id WHERE userNiveaux.userId = ".$_SESSION['id'];
    $statement = $connection->prepare($sql);
    $statement->execute();

    $niveaux = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
?>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-body bg-light mt-5">
            <h2>Generer un Exam</h2>
            <div class="row">
              <div class="col-md-12">

                <form method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="type">Type</label>
                      <select class="form-control" id="type" name="typeExamId">
                      <?php foreach ($result as $row) : ?>
                        <option  value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="contenue">Variants</label>
                            <input class="form-control" type="text" name="variants" id="variants" placeholder="Entrez le nombre de variants ...">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="contenue">Nombre de Questions</label>
                            <input class="form-control" type="text" name="questionsNombres" id="questions" placeholder="Entrez le nombre de questions ...">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="contenue">Durée</label>
                            <input class="form-control" type="number" name="duree" id="duree" placeholder="Entrez la duree (minutes) ...">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                        <label for="niveau">Niveaux</label>
                        <select class="form-control" id="niveau" multiple="multiple" name="niveaux[]">
                        <?php foreach ($niveaux as $row) : ?>
                          <option  value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                        <?php endforeach; ?>
                        </select>
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                        <label for="filieres">Filiéres</label>
                        <select class="form-control" id="filieres" multiple="multiple" name="filieres[]">
                        <?php foreach ($filliers as $row) : ?>
                          <option  value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                        <?php endforeach; ?>
                        </select>
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                        <label for="modules">Modules</label>
                        <select class="form-control" id="modules" multiple="multiple" name="modules[]">
                        <?php foreach ($modules as $row) : ?>
                          <option  value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                        <?php endforeach; ?>
                        </select>
                      </div>
                      </div>
                    </div>
                  </div>

                  <a class="btn btn-danger pull-right" href="index.php" style="margin: 0px 5px">Annuler</a>
                  <input class="btn btn-success pull-right" type="submit" name="submit" value="Submit">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php require "../../templates/footer.php"; ?>
