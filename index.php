<?php
if (!empty($_GET['error'])) {
    $error = $_GET['error'];
    unset($_GET['error']);
} else {
    $error = null;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="shortcut icon" type="image/svg" href="img/icon.svg" />
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<?php
include "funciones.php";
barramenu(); ?>

<body>
    <br>
    <h1 align="center">Ingrese los datos separados por espacios</h1>
    <form method="post" action="resultado.php">
        <div class="container">
            <?php
            if (!empty($error)) {
                // recorremos el arreglo
                echo "<div class='alert alert-danger' role='alert'>Error: colocaste un espacio de mas o colocaste un solo número.</div>";
            }
            ?>
            <div class="row">
                <div class="col-md-12">
                    <label for="etiqueta1">
                        Datos:
                    </label>
                    <textarea class="form-control" required id="datos" name="datos" rows="10" placeholder="12 13 12 32..."></textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    Clases personalizadas
                </div>
                <div class="col-md-6">
                    <input type="number" name="clases" id="clases" class="form-control" placeholder="0" value=0>
                </div>
            </div>
            <br>
            <div class="row">
                <input class="btn btn-block btn-lg" style="background-color: purple; color:white;" type="submit" value="Enviar Datos">
            </div>
        </div>
        <br>

    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script type="text/javascript">
        // Initialize our function when the document is ready for events.
        jQuery(document).ready(function() {
            // Listen for the input event.
            jQuery("#datos").on('input', function(evt) {
                // Allow only numbers.
                jQuery(this).val(jQuery(this).val().replace(/[^0-9- -.]/g, ''));
            });
        });
    </script>
    <script type="text/javascript">
        // Initialize our function when the document is ready for events.
        jQuery(document).ready(function() {
            // Listen for the input event.
            jQuery("#clases").on('input', function(evt) {
                // Allow only numbers.
                jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->

</html>