<?php include "templates/header.php"; ?>

  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card card-body bg-light mt-5">
          <h2>Dashboard <small class="text-muted"><?php echo $_SESSION['email']; ?></small></h2>
          <p>Welcome to the dashboard <?php echo $_SESSION['name']; ?></p>
          <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
        </div>
      </div>
    </div>
  </div>
<?php include "templates/footer.php"; ?>
