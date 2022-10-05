<?php
require '_connec.php';
require 'functions.php';

?>
<form action="" method="POST">
    <label for="firstname">Prénom :</label>
    <input type="text" name="firstname" id="firstname" placeholder="Prénom">
    <label for="lastname">Nom :</label>
    <input type="text" name="lastname" id="lastname" placeholder="Nom">
    <button type="submit">Envoyer</button>
</form>

<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $firstname = cleanPost($_POST['firstname']);
    $lastname = cleanPost($_POST['lastname']);

    if (empty($firstname) && strlen($firstname) < 45)
        $errors[] = '<p>Vous devez renseigner votre prénom et votre prénom doit être inférieur à 45 caractères.</p>';
    if (empty($lastname) && strlen($lastname) < 45)
        $errors[] = '<p>Vous devez renseigner votre nom et votre nom doit être inférieur à 45 caractères.</p>';
    if (empty($errors)) {
        $req = $pdo->prepare('INSERT INTO friend VALUES(NULL, :firstname, :lastname)');
        $req->execute(array(
            ':firstname' => $firstname,
            ':lastname' => $lastname
        ));
        $req = "SELECT * FROM friend";
        $statement = $pdo->query($req);
        $friends = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo '<p>Félicitations, tu es notre "Friend"!</p>';
        '<ul>';
        foreach ($friends as $friend) {
            echo "<li>" . $friend['firstname'] . " " . $friend['lastname'] . "</li>" . PHP_EOL;
        }
        '</ul>';
    } else {
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
    }
}

?>