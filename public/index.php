<?php include "templates/header.php"; ?>

<?php include "shared/publicnavbar.php"; ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card card-body bg-light mt-5">
          <h2>Espace <?php echo $_SESSION['role']; ?></h2>
          <p>Bienvenue Dans le Tableau de Bord.</p>
        </div>
      </div>
    </div>
  </div>
<?php include "templates/footer.php"; ?>
