<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Comptes Bancaires</title>
    <link rel="stylesheet" type="text/css" href="stylerest.css">

</head>
<body>

<h2>Gestion des Comptes Bancaires</h2>

<form action="" method="post">
    <button  class="add"    type="submit" name="action" value="add">Ajouter Compte</button>
    <button  class="delete" type="submit" name="action" value="delete">Supprimer Compte</button>
    <button  class="edit"   type="submit" name="action" value="edit">Modifier Compte</button>
</form>

<?php

function GET($url)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl); 
    curl_close($curl);
    return $response;
}

// Endpoint du service web REST
$serviceUrl = "http://localhost:8082/banque/comptes";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : null;

   
    if ($action === 'add') {
        header("Location: ajouterCompte.php");
        exit();
    } elseif ($action === 'delete') {
       echo '<form action="" method="post">';
       echo '    <label for="deleteId">ID du Compte à Supprimer:</label>';
       echo '    <input type="number" name="deleteId" required>';
       echo '    <button class="delete" type="submit" name="action" value="delete">Supprimer Compte</button>';
       echo '</form>';
       
       if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
        $deleteId = isset($_POST['deleteId']) ? $_POST['deleteId'] : null;
    
        if ($deleteId !== null) {
            $serviceUrl = "http://localhost:8082/banque/comptes/{$deleteId}";
            $ch = curl_init($serviceUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_exec($ch);
    
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
    
            if ($httpCode == 200) {
                echo "<p>Suppression du compte ID={$deleteId} - Réussie</p>";
            } else {
                echo "<p>Suppression du compte ID={$deleteId} - Réussie</p>";
            }
        } else {
            echo "<p>ID de compte manquant pour la suppression</p>";
        }
       }
    } elseif ($action === 'edit') {
            // Obtenez les données du formulaire
            header("Location: modifierCompte.php");
            exit();
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $type = isset($_POST['type']) ? $_POST['type'] : null;
            $solde = isset($_POST['solde']) ? $_POST['solde'] : null;
            $date = isset($_POST['date']) ? $_POST['date'] : null;

            // Construisez votre URL de service web pour la modification
            $serviceUrl = "http://localhost:8082/banque/comptes/{$id}";

            $data = array(
                'id' => $id,
                'type' => $type,
                'solde' => $solde,
                'dateDeCreation' => $date
            );

            $ch = curl_init($serviceUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode == 200) {
                echo "<p>Modification du compte ID={$id} - Réussie</p>";
            } else {
                echo "<p>Modification du compte ID={$id} - Échouée</p>";
                echo "<p>HTTP Code: {$httpCode}</p>";
                echo "<p>CURL Error: " . curl_error($ch) . "</p>";
            }

            curl_close($ch);
        }
}
$response = GET($serviceUrl);
$comptes = json_decode($response, true);

if (!empty($comptes)) {
    echo "<h3>Liste des Comptes</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Type</th><th>solde</th><th>Date de Création</th></tr>";

    
    foreach ($comptes as $compte) {
        echo "<tr>";
        echo "<td>{$compte['id']}</td>";
        echo "<td>{$compte['type']}</td>";
        echo "<td>{$compte['solde']}</td>";
        echo "<td>{$compte['dateDeCreation']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

</body>
</html>
