

<?php require "../../templates/header.php"; ?>
<?php include "../../shared/navbar.php"; ?>

<?php
  require_once '../../../connection.php';

   $password_err = $confirm_password_err = '';
if (isset($_POST['submit'])) {

      if(empty($_POST['password'])){
        $password_err = 'Please enter password';
      } elseif(strlen($_POST['password']) < 6){
        $password_err = 'Password must be at least 6 characters';
      }

      // Validate Confirm password
      if(empty($_POST['confirm_password'])){
        $confirm_password_err = 'Please confirm password';
      } else {
        if($_POST['password'] !== $_POST['confirm_password']){
          $confirm_password_err = 'Passwords do not match';
        }
      }
      if(empty($password_err) && empty($confirm_password_err)) {

        try {
          $user =[
            "id"        => $_GET['id'],
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "userTypeId"     => $_POST['userTypeId'],
            "password"  => password_hash($_POST['password'], PASSWORD_DEFAULT)
          ];

          $sql = "UPDATE users
          SET id = :id,
          firstname = :firstname,
          lastname = :lastname,
          email = :email,
          userTypeId = :userTypeId,
          password = :password
          WHERE id = :id";

          $statement = $connection->prepare($sql);
          $statement->execute($user);
          header('location: index.php');
        } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }
      }
}

if (isset($_GET['id'])) {
  try {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


      try  {
        $sql = "SELECT * FROM typeusers";
        $statement = $connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();
      } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
      }
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
            <h2>Modifier un utilisateur</h2>
            <div class="row">
              <div class="col-md-12">



                <form method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="firstname">Nom</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $user['firstname']; ?>" placeholder="Entrez le Nom ...">
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="lastname">Prénom</label>
                    <input class="form-control" type="text" name="lastname" id="lastname" value="<?php echo $user['lastname']; ?>" placeholder="Entrez le Prénom ...">
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="<?php echo $user['email']; ?>" placeholder="Entrez l'Email ...">
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="userTypeId">
                    <?php foreach ($result as $row) : ?>
                      <option value="<?php echo $row["id"]; ?>" <?php echo $row["id"] == $user['userTypeId'] ? 'selected' : ''; ?>><?php echo $row["name"]; ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                  </div>

                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                          <label for="password">Password</label>
                          <input type="password" name="password" class="form-control form-control-lg" >
                          <span class="control-label"><?php echo $password_err; ?></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                          <label for="confirm_password">Confirm Password</label>
                          <input type="password" name="confirm_password" class="form-control form-control-lg">
                          <span class="control-label"><?php echo $confirm_password_err; ?></span>
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
