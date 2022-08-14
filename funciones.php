<?php
function contarValores($datos, $buscado)
{
    $str = ", " . implode(", ", $datos) . ",";
    $count = substr_count($str, " " . $buscado . ",");
    return $count;
}
function sacarFrecuencia($limInf, $limSup, $datos)
{
    $freq = 0;
    for ($i = $limInf; $i <= $limSup; $i++) {
        $freq += contarValores($datos, $i);
    }
    return $freq;
}
function sacarIntervalos($clases, $minimo, $maximo, $amplitud)
{
    $intervalos = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        if ($i == 0) {
            //if ($minimo <= 9) {
            $intervalos[$i][0] = $minimo;
            $intervalos[$i][1] = $intervalos[$i][0] + $amplitud;
            //} else {
            //  $intervalos[$i][0] = intval($minimo / 10) * 10;
            //$intervalos[$i][1] = $intervalos[$i][0] + $amplitud;
            //}
        } elseif ($i == $clases - 1) {
            $intervalos[$clases - 1][0] = $intervalos[$i - 1][1] + 1;
            $intervalos[$clases - 1][1] = $intervalos[$i][0] + $amplitud;
        } else {
            $intervalos[$i][0] = $intervalos[$i - 1][1] + 1;
            $intervalos[$i][1] = $intervalos[$i][0] + $amplitud;
        }
    }
    return $intervalos;
}
function sacarClases($n_datos)
{
    $clases = 0;
    for ($i = 1; $i <= 10; $i++) {
        if (2 ** $i >= $n_datos) {
            $clases = $i;
            break;
        } else {
        }
    }
    return $clases;
}
function sacarExpClases($n_datos)
{
    $exponente_clases = 0;
    for ($i = 1; $i <= 10; $i++) {
        if (2 ** $i >= $n_datos) {
            $exponente_clases = 2 ** $i;
            break;
        } else {
        }
    }
    return $exponente_clases;
}
function sacarPuntosMedios($clases, $intervalos)
{
    $puntosMedios = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        $puntosMedios[$i] = ($intervalos[$i][0] + $intervalos[$i][1]) / 2;
    }
    return $puntosMedios;
}
function sacarFrecuenciasAbsolutas($clases, $intervalos, $datos)
{
    $frecuencias = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        $frecuencias[$i] = sacarFrecuencia($intervalos[$i][0], $intervalos[$i][1], $datos);
    }
    return $frecuencias;
}
function sacarFR($clases, $frecuencias, $n_datos)
{
    $frecuenciasRelativas = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        $frecuenciasRelativas[$i] = $frecuencias[$i] / $n_datos;
    }
    return $frecuenciasRelativas;
}
function sacarFA($clases, $frecuencias)
{
    $frecuenciaAcum = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        if ($i == 0) {
            $frecuenciaAcum[$i] = $frecuencias[$i];
        } else {
            $frecuenciaAcum[$i] = $frecuencias[$i] + $frecuenciaAcum[$i - 1];
        }
    }
    return $frecuenciaAcum;
}
function sacarFX($clases, $frecuencias, $puntosMedios)
{
    $fx = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        $fx[$i] = $frecuencias[$i] * $puntosMedios[$i];
    }
    return $fx;
}
function sacarFXCuadrado($clases, $fx, $puntosMedios)
{
    $fx2 = null;
    for ($i = 0; $i <= $clases - 1; $i++) {
        $fx2[$i] = $fx[$i] * $puntosMedios[$i];
    }
    return $fx2;
}
function sacarSesgo($media, $mediana, $moda)
{
    $medTC = array("media" => $media, "mediana" => $mediana, "moda" => $moda);
    $medMay = max($medTC);
    $keySesgo = array_search($medMay, $medTC, true);
    $sesgo = null;
    if ($keySesgo == "media") {
        $sesgo = "Positivo";
    } else {
        $sesgo = "Negativo";
    }
    return $sesgo;
}
//Funcion de la barra menu en hecha con bootstrap, para hacer mas sencillo el manejo de la pagina, asi solo llamamos a la funcion.
function barramenu()
{
?>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: purple; color:white;">
        <a class="navbar-brand" href="index.php">Principal</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="ejemplo1.php">Ejemplo 1</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="ejemplo2.php">Ejemplo 2</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="ejemplo3.php">Ejemplo 3</a>
                </li>
            </ul>
        </div>
    </nav>
<?php
}
