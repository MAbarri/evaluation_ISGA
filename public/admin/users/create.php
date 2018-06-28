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
        $userid = $connection->lastInsertId();

        foreach ($_POST['niveaux'] as $selectedOption) {
            $new_userniveaux = array(
              "userId" => $userid,
              "niveauId" => $selectedOption
            );
            $sql = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "userNiveaux",
              implode(", ", array_keys($new_userniveaux)),
              ":" . implode(", :", array_keys($new_userniveaux))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_userniveaux);
        }
        foreach ($_POST['filieres'] as $selectedOption) {
            $new_userfilliere = array(
              "userId" => $userid,
              "filiereId" => $selectedOption
            );
            $sql = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "userFilieres",
              implode(", ", array_keys($new_userfilliere)),
              ":" . implode(", :", array_keys($new_userfilliere))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_userfilliere);
        }
        foreach ($_POST['modules'] as $selectedOption) {
            $new_usermodule = array(
              "userId" => $userid,
              "moduleId" => $selectedOption
            );
            $sql = sprintf(
              "INSERT INTO %s (%s) values (%s)",
              "userModules",
              implode(", ", array_keys($new_usermodule)),
              ":" . implode(", :", array_keys($new_usermodule))
            );
            $statement = $connection->prepare($sql);
            $statement->execute($new_usermodule);
        }

        header('location: index.php');
      } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
      }

    }
}


  try  {
    $sql = "SELECT * FROM typeusers";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $usertypes = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try  {
    $sql = "SELECT * FROM filieres";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $filliers = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try  {
    $sql = "SELECT * FROM modules";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $modules = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  try  {
    $sql = "SELECT * FROM niveaux";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $niveaux = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
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
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type" name="userTypeId">
                    <?php foreach ($usertypes as $row) : ?>
                      <option  value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
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
