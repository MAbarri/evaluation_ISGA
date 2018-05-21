<?php include "../../templates/header.php"; ?>

<?php include "../../shared/navbar.php"; ?>
<?php

require_once '../../../connection.php';

  try  {
    $sql = "SELECT users.id, firstname, lastname, email, typeusers.name FROM users INNER JOIN typeusers ON users.userTypeId = typeusers.id";
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
          <h2>Administration d'utilisateurs</h2>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td>Nom</td>
                <td>Prénom</td>
                <td>email</td>
                <td>Type</td>
                <td>Actions</td>
              </tr>

              <?php foreach ($result as $row) : ?>
              <tr>
                <td><?php echo $row["firstname"]; ?></td>
                <td><?php echo $row["lastname"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
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
					<!-- <ul>
						<li><a href="create.php"><strong>Create</strong></a> - add a user</li>
						<li><a href="read.php"><strong>Read</strong></a> - find a user</li>
						<li><a href="update.php"><strong>Update</strong></a> - edit a user</li>
						<li><a href="delete.php"><strong>Delete</strong></a> - delete a user</li>
					</ul> -->
        </div>
      </div>
    </div>
  </div>
<?php include "../../templates/footer.php"; ?>
