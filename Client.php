<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Mon Formulaire</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
        <?php

            
            $res = null;
            $resultatValidation = null;
            $messageValidate = '' ; 
            $emoji = '';
            if (isset($_POST['submit'])) {
                $date = $_POST['date'];
                $numeroCarte = $_POST['numeroCarte'];
                $typeCarte = $_POST['typeCarte'];

                if (class_exists('SoapClient')) {
                    $clientSOAP = new SoapClient("http://localhost:8084/CardValidaterWS?wsdl");

                   $card = array(
                    'card'=> array('number' => $numeroCarte,
                        'expiryDate' => $date, 
                        'type' =>$typeCarte ));
                   
                        try {
                            $res = $clientSOAP->luhn(array('number' => $numeroCarte));
                            $result = $clientSOAP->validate($card);
                            
            
                            if ($result && isset($result->return)) {
                                $luhnResult = $res->return ; 
                                $emoji = ($result->return == true) ? "🎉" : "😣";
                                echo "<h5 style='color: #D607BA; padding: 10px; font-size : 20px;font-family: cursive; border-radius: 5px;' class='result-message'>" . $emoji . " " . (($result->return == true) ? "Félicitations, votre carte est valide !" : "Désolé, votre carte n'est pas valide") . "</h5>";
                            } else {
                                echo "<h5 class='result-message'>Erreur : La propriété 'return' n'est pas définie dans la réponse SOAP.</h5>";
                            }
            
                        } catch (SoapFault $e) {
                            echo "<h5 class='result-message'>Erreur SOAP : " . $e->getMessage() . " (Code : " . $e->getCode() . ")</h5>";
                }       }
                  
            }
         ?>
           
            
            <header>Mon Formulaire</header>
            <form action="" method="post">
            <div class="field input">
                <label for="date">Date d'expiration</label>
                <input type="date" name="date" id="date" required>
            </div>


                <div class="field input">
                    <label for="numeroCarte">Numero de la carte</label>
                    <input type="text" name="numeroCarte" id="numeroCarte" maxlength="16" required>
                </div>

                <div class="field input">
                    <label>Type de carte</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" name="typeCarte" id="masterCard" value="MasterCard" required>
                            <label for="masterCard">MasterCard</label>
                        </div>

                        <div class="radio-option">
                            <input type="radio" name="typeCarte" id="visa" value="Visa" required>
                            <label for="visa">Visa</label>
                        </div>

                        <div class="radio-option">
                            <input type="radio" name="typeCarte" id="amex" value="American Express" required>
                            <label for="amex">American Express</label>
                        </div>
                    </div>

                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Envoyer" required>
                    <input type="reset" class="btn" value="Reset">
                </div>
            </form>
            <!-- Afficher le résultat de la validation -->
            <?php
            
               //if($result->return==false)
                 // echo "<p>Résultat de la validation : " .$result->return. "</p>";
            
            ?>
        </div>
    </div>
</body>
</html>
