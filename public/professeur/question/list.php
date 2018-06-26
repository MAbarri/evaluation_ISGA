<?php include "../../templates/header.php"; ?>

<?php include "../../shared/publicnavbar.php"; ?>
<?php

require_once '../../../connection.php';

  try  {
    $sql = "SELECT COUNT(reponse.id) as totalreponses, CONCAT(users.firstName ,' ', users.lastName) as owner, typequestion.name as type, questions.contenue, difficulte
    FROM questions
        INNER JOIN users ON users.id = questions.userId
        INNER JOIN typequestion ON typequestion.id = questions.typeQuestionId
        INNER JOIN reponse ON reponse.questionId = questions.id
        GROUP BY reponse.questionId";
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
          <h2>Base de données Question</h2>
          <div class="row">

            <table class="col-md-12 table table-hover">
              <tr>
                <td>Propriétaire</td>
                <td>Type</td>
                <td>Contenue</td>
                <td>Nombre de Choix</td>
                <!-- <td>Difficulté</td> -->
              </tr>

              <?php foreach ($result as $row) : ?>
              <tr>
                <td><?php echo $row["owner"]; ?></td>
                <td><?php echo $row["type"]; ?></td>
                <td><?php echo $row["contenue"]; ?></td>
                <td><?php echo $row["totalreponses"]; ?></td>
                <!-- <td><?php echo $row["difficulte"]; ?></td> -->
              </tr>
            <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include "../../templates/footer.php"; ?>
