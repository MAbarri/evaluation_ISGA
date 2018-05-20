<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

 require_once '../../../connection.php';

if (isset($_POST['submit'])) {

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
?>
<?php require "../../templates/header.php"; ?>

<?php include "../../shared/navbar.php"; ?>
  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
  <?php endif; ?>

    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card card-body bg-light mt-5">
            <h2>Administration d'utilisateurs</h2>
            <div class="row">

            <h2>Add a user</h2>

            <form method="post">
              <input type="text" value="2" name="userTypeId" id="userTypeId" style="visibility:hidden">
              <label for="firstname">First Name</label>
              <input type="text" name="firstname" id="firstname">
              <label for="lastname">Last Name</label>
              <input type="text" name="lastname" id="lastname">
              <label for="email">Email Address</label>
              <input type="text" name="email" id="email">
              <label for="email">Mot de passe</label>
              <input type="password" name="password" id="password">
              <input type="submit" name="submit" value="Submit">
            </form>

            <a href="index.php">Back to home</a>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php require "../../templates/footer.php"; ?>
