<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'Ajout de Compte</title>
    <link rel="stylesheet" type="text/css" href="style2.css">

</head>
<body>

<h2>Formulaire d'Ajout de Compte</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action === 'add') {
        $type = isset($_POST['type']) ? $_POST['type'] : null;
        $date = isset($_POST['date']) ? $_POST['date'] : null;
        $solde = isset($_POST['solde']) ? $_POST['solde'] : null;

        

        $addData = array(
            'type' => $type,
            'dateDeCreation' => $date,
            'solde' => $solde,
        );

        $curl = curl_init("http://localhost:8082/banque/comptes");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($addData));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);

        echo "Ajout du compte : " . $response;
        
        curl_close($curl);
    }
}
?>

<form action="ajouterCompte.php" method="post">
    <label for="type">Type de Compte:</label>
    <input type="text" name="type" required><br>

    <label for="solde">Solde:</label>
    <input type="text" name="solde" required><br>

    <label for="date">Date de Création:</label>
    <input type="date" name="date" required><br>

    <button class="submit" type="submit" name="action" value="add">Ajouter Compte</button>
</form>

</body>
</html>
