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
      try  {
        $new_user = array(
          "firstname" => $_POST['firstname'],
          "lastname"  => $_POST['lastname'],
          "email"     => $_POST['email'],
          "userTypeId"     => $_POST['userTypeId'],
          "password"  => password_hash($_POST['password'], PASSWORD_DEFAULT)
        );

        $sql = sprintf(
          "INSERT INTO %s (%s) values (%s)",
          "users",
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
}
?>
<?php require "../../templates/header.php"; ?>

<?php include "../../shared/navbar.php"; ?>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-body bg-light mt-5">
            <h2>Ajouter un utilisateur</h2>
            <div class="row">
              <div class="col-md-12">

                <form method="post">
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="firstname">Nom</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Entrez le Nom ...">
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="lastname">Prénom</label>
                    <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Entrez le Prénom ...">
                  </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" placeholder="Entrez l'Email ...">
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
