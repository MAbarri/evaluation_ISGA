

<?php require "../../templates/header.php"; ?>
<?php include "../../shared/navbar.php"; ?>

<?php
  require_once '../../../connection.php';

if (isset($_POST['submit'])) {


        try {
          $user =[
            "id"        => $_GET['id'],
            "name" => $_POST['name']
          ];

          $sql = "UPDATE typeusers
          SET id = :id,
          name = :name
          WHERE id = :id";

          $statement = $connection->prepare($sql);
          $statement->execute($user);
          header('location: index.php');
        } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }
}

if (isset($_GET['id'])) {
  try {
    $id = $_GET['id'];

    $sql = "SELECT * FROM typeusers WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-body bg-light mt-5">
            <h2>Modifier un type d'utilisateur</h2>
            <div class="row">
              <div class="col-md-12">



                <form method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="name">Nom</label>
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo $user['name']; ?>" placeholder="Entrez le Nom ...">
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
