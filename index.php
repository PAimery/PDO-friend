<?php

require_once '_connec.php';

$pdo = new PDO(DSN, USER, PASS);

$errors = [];
$lengthName = 45;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


  $friend = array_map('trim', $_POST);

  if (empty($_POST['firstname']));
  $errors[] = "Le prénom est obligatoire";

  if (mb_strlen($_POST['firstname']) > $lengthName);
  $errors[] = "La longueur du prénom est trop grande";

  if (empty($_POST['lastname']));
  $errors[] = "Le nom est obligatoire";

  if (mb_strlen($_POST['lastname']) > $lengthName);
  $errors[] = "La longueur du nom est trop grande";


  if (empty($errors)) {
    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    $statement->execute();
    header('Location: ');
    exit();
  }
}
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friend = $statement->fetchAll(PDO::FETCH_ASSOC); // same as $statement->fetchAll()
var_dump($friend);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <main class="container">
  <h1>Liste d'amis</h1>
    <ul>
        <?php foreach ($friend as $friend): ?>
            <li><?= $friend['firstname'] ?></li>
            <li><?= $friend['lastname'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h1>Inscriptions</h1>
    <?php if (count($errors) > 0) : ?>
      <ul>
        <?php foreach ($errors as $error) : ?>
          <li><?= $error ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form action="" method="post">
      <div>
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>
      </div>
      <div>
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required>
      </div>
      <div class="button">
        <button type="submit">Envoyer votre message</button>
      </div>
    </form>
  </main>
</body>

</html>