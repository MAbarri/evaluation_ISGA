
<?php require "../../templates/header.php"; ?>

<?php include "../../shared/publicnavbar.php"; ?>
<?php
 require_once '../../../connection.php';


 $password_err = $confirm_password_err = '';

if (isset($_POST['submit'])) {

      try  {
        $new_user = array(
          "contenue" => $_POST['contenue'],
          "userId" => $_SESSION['id'],
          "typeQuestionId"     => $_POST['questionTypeId']
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "questions",
          implode(", ", array_keys($new_user)),
          ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
        $questionid = $connection->lastInsertId();

        try  {
          $array = array(
              array($_POST['choix1'], isset($_POST['someSwitchOption001']) && $_POST['someSwitchOption001'] ? 1 : 0, $questionid),
              array($_POST['choix2'], isset($_POST['someSwitchOption002']) && $_POST['someSwitchOption002'] ? 1 : 0, $questionid),
              array($_POST['choix3'], isset($_POST['someSwitchOption003']) && $_POST['someSwitchOption003'] ? 1 : 0, $questionid),
              array($_POST['choix4'], isset($_POST['someSwitchOption004']) && $_POST['someSwitchOption004'] ? 1 : 0, $questionid),
          );
          foreach($array as $arrayItem){
            $responsessql = "INSERT INTO reponse (contenue, correct, questionId) values (?,?,?)";
            $responssestatement = $connection->prepare($responsessql);
            $responssestatement->execute($arrayItem);
          }

          header('location: ../../index.php');
        } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }

      } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }
}


  try  {
    $sql = "SELECT * FROM typequestion";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }

?>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-body bg-light mt-5">
            <h2>Proposer une Question</h2>
            <div class="row">
              <div class="col-md-12">

                <form method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="type">Type</label>
                      <select class="form-control" id="type" name="questionTypeId">
                      <?php foreach ($result as $row) : ?>
                        <option  value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                      <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="contenue">Texte du Question</label>
                          <textarea rows="4" class="form-control" type="text" name="contenue" id="contenue"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-11" style="margin: 0 0 5px 0;">
                        <input class="form-control" type="text" name="choix1" id="choix1" placeholder="Entrez un choix ...">
                      </div>
                      <div class="col-md-1" style="padding: 12px;">
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess1" name="someSwitchOption001" type="checkbox" value="1"/>
                            <label for="someSwitchOptionSuccess1" class="label-success"></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-11" style="margin: 0 0 5px 0;">
                        <input class="form-control" type="text" name="choix2" id="choix1" placeholder="Entrez un choix ...">
                      </div>
                      <div class="col-md-1" style="padding: 12px;">
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess2" name="someSwitchOption002" type="checkbox" value="0"/>
                            <label for="someSwitchOptionSuccess2" class="label-success"></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-11" style="margin: 0 0 5px 0;">
                        <input class="form-control" type="text" name="choix3" id="choix1" placeholder="Entrez un choix ...">
                      </div>
                      <div class="col-md-1" style="padding: 12px;">
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess3" name="someSwitchOption003" type="checkbox" value="0"/>
                            <label for="someSwitchOptionSuccess3" class="label-success"></label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-11" style="margin: 0 0 5px 0;">
                        <input class="form-control" type="text" name="choix4" id="choix1" placeholder="Entrez un choix ...">
                      </div>
                      <div class="col-md-1" style="padding: 12px;">
                        <div class="material-switch pull-right">
                            <input id="someSwitchOptionSuccess4" name="someSwitchOption004" type="checkbox" value="0"/>
                            <label for="someSwitchOptionSuccess4" class="label-success"></label>
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