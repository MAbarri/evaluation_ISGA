<?php include "../../templates/header.php"; ?>

<?php include "../../shared/navbar.php"; ?>
<?php

require_once '../../../connection.php';

  try  {
    $sql = "SELECT * FROM modules";
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
          <h2>Administration de modules</h2>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td>Nom</td>
                <td>Actions</td>
              </tr>

              <?php foreach ($result as $row) : ?>
              <tr>
                <td><?php echo $row["name"]; ?></td>
                <td>
                <a style="height: auto;" class="btn btn-xs btn-primary" href="update-single.php?id=<?php echo $row["id"]; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a style="height: auto;" class="btn btn-xs btn-danger" href="delete.php?id=<?php echo $row["id"]; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
            </table>
          </div>
          <div class="row">
            <div class="col-md-12">
              <a type="button" href="create.php" class="btn btn-md btn-default pull-right"><i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include "../../templates/footer.php"; ?>
