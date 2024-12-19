<!-- modifierCompte.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier Compte</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>

<h2>Modifier Compte</h2>

<form action="" method="post">
    <label for="id">ID du Compte:</label>
    <input type="text" name="id" required><br>

    <label for="type">Type de Compte:</label>
    <input type="text" name="type" required><br>

    <label for="solde">Solde:</label>
    <input type="text" name="solde" required><br>

    <label for="date">Date de Création:</label>
    <input type="date" name="date" required><br>

    <button class="submit" type="submit" name="action" value="edit">Modifier Compte</button>
</form>

</body>
</html>
