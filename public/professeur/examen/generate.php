
<?php require "../../templates/header.php"; ?>

<?php include "../../shared/publicnavbar.php"; ?>
<?php
 require_once '../../../connection.php';


 $password_err = $confirm_password_err = '';

if (isset($_POST['submit'])) {

    // $sql = "SELECT * FROM question LIMIT ".$_POST['variants']*$_POST['questions'];
    // $statement = $connection->prepare($sql);
    // $statement->execute();
    //
    // $result = $statement->fetchAll();


      try  {
        $new_user = array(
          "typeExamId" => $_POST['typeExamId'],
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
                            <input class="form-control" type="text" name="questions" id="questions" placeholder="Entrez le nombre de questions ...">
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
