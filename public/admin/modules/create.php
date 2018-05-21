<?php
 require_once '../../../connection.php';

if (isset($_POST['submit'])) {

      try  {
        $new_user = array(
          "name" => $_POST['name']
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "modules",
          implode(", ", array_keys($new_user)),
          ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        header('location: index.php');
      } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }
}
?>
<?php require "../../templates/header.php"; ?>

<?php include "../../shared/navbar.php"; ?>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-body bg-light mt-5">
            <h2>Ajouter un module</h2>
            <div class="row">
              <div class="col-md-12">

                <form method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="firstname">Nom</label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Entrez le Nom ...">
                  </div>
                  </div>
                  <input type="text" value="2" name="userTypeId" id="userTypeId" style="visibility:hidden">
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
