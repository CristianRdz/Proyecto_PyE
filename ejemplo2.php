<?php
include 'funciones.php';
//$ingresados = "271 363 159 76 227 337 295 319 250 279 205 279 266 199 177 162 232 303 192 181 321 309 246 278 50 41 335 116 100 151 240 474 297 170 188 320 429 294 570 342 279 235 434 123 325";
$ingresados = "8 8 6 11 11 9 8 5 11 4 8 5 14 7 12 8 6 11 9 7 9 15 8 8 12 5 9 8 5 9 10 11 3 9 8 6";
//$ingresados = "128 56 54 91 190 23 160 298 445 50 578 494 37 677 18 74 70 868 108 71 466 23 84 38 26 814 17";
//$ingresados = "4 6 8 7 9 6 3 7 7 6 7 1 4 7 7 4 6 4 10 2 4 6 3 4 6 8 4 3 3 6 8 8 4 6 4 6 5 5 9 6 8 8 6 5 10";
//$ingresados = "312 2753 2595 6057 7624 6624 6362 6575 7760 7085 7272 5967 5256 6160 6238 6709 7193 5631 6490 6682 7829 7091 6871 6230 7253 5507 5676 6974 6915 4999 5689 6143 7086";
$datos = explode(" ", $ingresados);
$n_datos = count($datos);
$exponente_clases = 0;
$maximo = max($datos);
$minimo = min($datos);
/*print_r($datos);
echo "<br>";
echo "<br>";
echo "<br>";
echo "Valor maximo: " . $maximo . "<br/>";
echo "Valor minimo: " . $minimo . "<br/>";*/
//$clases = intval(sqrt($n_datos));
$s_clases = 0;
for ($i = 1; $i <= 10; $i++) {
    if (2 ** $i >= $n_datos) {
        $exponente_clases = 2 ** $i;
        $clases = $i;
        break;
    } else {
    }
}
//$s_clases = 1 + (3.322 * (log10($n_datos)));
/*echo "<br>" . $s_clases . "<br>";
echo $exponente_clases;*/
$clases = 5;
$amplitud = intval(($maximo - $minimo) / $clases);
$intervalos = sacarIntervalos($clases, $minimo, $maximo, $amplitud);
$frecuencias = sacarFrecuenciasAbsolutas($clases, $intervalos, $datos);
$puntosMedios = sacarPuntosMedios($clases, $intervalos);
$frecuenciasRelativas = sacarFR($clases, $frecuencias, $n_datos);
$frecuenciaAcum = sacarFA($clases, $frecuencias);
$fx = sacarFX($clases, $frecuencias, $puntosMedios);
$fx2 = sacarFXCuadrado($clases, $fx, $puntosMedios);
$r_clases = range(1, $clases);
$sumFX = array_sum($fx);
$sumFX2 = array_sum($fx2);
$nsobre2 = $n_datos / 2;
/*foreach ($frecuenciaAcum as $key => $value) {
    if ($value <= $nsobre2) {
        $arrMod[] = $value;
    }
}
$acumCercaDeN = max($arrMod);
$keyTendencias = array_search($acumCercaDeN , $frecuenciaAcum, true);*/
$maxFreq = max($frecuencias);
$keyTendencias = array_search($maxFreq, $frecuencias, true);
$mediana = $sumFX / $n_datos;
$media = $intervalos[$keyTendencias][0] + (($nsobre2 - $frecuenciaAcum[$keyTendencias - 1]) / $frecuencias[$keyTendencias]) * $amplitud;
$moda = $puntosMedios[$keyTendencias];
$i_min = min($intervalos[0]);
$i_max = max($intervalos[$clases - 1]);
$amplitudVarianza = $i_max - $i_min;
$despt1 = (($sumFX ** 2) / $n_datos);
$desviacionEstandar = sqrt(($sumFX2 - $despt1) / ($n_datos - 1));
$sesgo = sacarSesgo($media, $mediana, $moda);
$datosGraficafreq2 = implode(", ", $frecuenciaAcum);
$datosGraficafreq = implode(", ", $frecuencias);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 2</title>
    <link rel="shortcut icon" type="image/svg" href="img/icon.svg" />
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
    <?php barramenu(); ?>
    <br>
    <h1 style="text-align: center">Tabla de frecuencias</h1>
    <div class="container">
        <div class="table-responsive-lg">
            <table class="table table-bordered table-hover" id="tabla">
                <thead class="thead" style="background-color: purple; color:white;">
                    <tr>
                        <th scope="col">Clases</th>
                        <th scope="col">Limite inferior del intervalo</th>
                        <th scope="col">Limite superior del intervalo</th>
                        <th scope="col">Frecuencia absoluta</th>
                        <th scope="col">Punto medio</th>
                        <th scope="col">Frecuencia relativa</th>
                        <th scope="col">Frecuencia acumulada</th>
                        <th scope="col">FX</th>
                        <th scope="col">FX^2</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    for ($i = 0; $i < $clases; $i++) {
                        $tabla = "<tr>
                <td>" . $r_clases[$i] . "</td>
                <td>" . $intervalos[$i][0] . "</td>
                <td>" . $intervalos[$i][1] . "</td>
                <td>" . $frecuencias[$i] . "</td>
                <td>" . $puntosMedios[$i] . "</td>
                <td>" . $frecuenciasRelativas[$i] . "</td>
                <td>" . $frecuenciaAcum[$i] . "</td>
                <td>" . $fx[$i] . "</td>
                <td>" . $fx2[$i] . "</td>
                </tr>";
                        echo $tabla;
                    }
                    ?>

                </tbody>
                <tfoot>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>&sum;<?php echo array_sum($frecuencias); ?></td>
                    <td></td>
                    <td>&sum;<?php echo array_sum($frecuenciasRelativas); ?></td>
                    <td></td>
                    <td>&sum;<?php echo array_sum($fx); ?></td>
                    <td>&sum;<?php echo array_sum($fx2); ?></td>
                </tfoot>
            </table>
        </div>
        <button id="btnExportar" class="btn btn-block btn-lg" style="background-color: purple; color:white;">
            <i class="fas fa-file-excel"></i> Exportar datos a Excel
        </button>
    </div>
    <br>
    <div class="container">
        <h2 style="text-align: center">Medidas de tendencia central</h2>
        <div class="row">
            <div class="col-md-4">
                Media
                <input type="text" disabled class="form-control" value=<?php echo $media ?>>
            </div>
            <div class="col-md-4">
                Mediana
                <input type="text" disabled class="form-control" value=<?php echo $mediana ?>>

            </div>
            <div class="col-md-4">
                Moda
                <input type="text" disabled class="form-control" value=<?php echo $moda ?>>
            </div>
        </div>
        <br>
        <h2 style="text-align: center">Medidas de dispersión</h2>
        <div class="row">
            <div class="col-md-4">
                Amplitud de variación
                <input type="text" disabled class="form-control" value=<?php echo $amplitudVarianza ?>>
            </div>
            <div class="col-md-4">
                Desviación estándar
                <input type="text" disabled class="form-control" value=<?php echo $desviacionEstandar ?>>

            </div>
            <div class="col-md-4">
                Sesgo
                <input type="text" disabled class="form-control" value=<?php echo $sesgo ?>>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <h2 style="text-align: center">Gráficas</h2>
        <div class="row">
            <div class="col-md-6">
                <h4 style="text-align: center">Histograma</h4>
                <canvas id="graficaFreq"></canvas>
            </div>
            <div class="col-md-6">
                <h4 style="text-align: center">Polígono</h4>
                <canvas id="graficaFreqLine"></canvas>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Ojiva</h4>
                <canvas id="grafOjiva"></canvas>
            </div>
        </div>
    </div>
    <br>
    <!--Javascript-->
    <script>
        const $btnExportar = document.querySelector("#btnExportar"),
            $tabla = document.querySelector("#tabla");

        $btnExportar.addEventListener("click", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: "Excel_Estadística_<?php echo date("d-m-Y H:i:s"); ?>", //Nombre del archivo de Excel
                sheetname: "Estadística", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
        });
        // Obtener una referencia al elemento canvas del DOM
        const $graficaHistograma = document.querySelector("#graficaFreq");
        // Las etiquetas son las que van en el eje X. 
        const etiquetasHistograma = [<?php
                                        for ($i = 0; $i < $clases; $i++) {
                                            echo '"Clase ' . $r_clases[$i] . '",';
                                        } ?>]
        // Podemos tener varios conjuntos de datos. Comencemos con uno
        const datosHistograma = {
            label: "Frecuencia absoluta",
            backgroundColor: "purple",
            borderColor: "rgb(255, 99, 132)",
            data: [<?php echo $datosGraficafreq; ?>]
        };
        new Chart($graficaHistograma, {
            type: 'bar', // Tipo de gráfica
            data: {
                labels: etiquetasHistograma,
                datasets: [
                    datosHistograma,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        });
        // Obtener una referencia al elemento canvas del DOM
        const $graficaPoligono = document.querySelector("#graficaFreqLine");
        // Las etiquetas son las que van en el eje X. 
        const etiquetasPoligono = [<?php
                                    for ($i = 0; $i < $clases; $i++) {
                                        echo '"Clase ' . $r_clases[$i] . '",';
                                    } ?>]
        // Podemos tener varios conjuntos de datos. Comencemos con uno
        const datosPoligono = {
            label: "Frecuencia absoluta",
            backgroundColor: "purple",
            borderColor: "rgb(255, 99, 132)",
            data: [<?php echo $datosGraficafreq; ?>]
        };
        new Chart($graficaPoligono, {
            type: 'line', // Tipo de gráfica
            data: {
                labels: etiquetasPoligono,
                datasets: [
                    datosPoligono,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        });

        // Obtener una referencia al elemento canvas del DOM
        const $graficaOjiva = document.querySelector("#grafOjiva");
        // Las etiquetas son las que van en el eje X. 
        const etiquetasOjiva = [<?php
                                for ($i = 0; $i < $clases; $i++) {
                                    echo '"Clase ' . $r_clases[$i] . '",';
                                } ?>]
        // Podemos tener varios conjuntos de datos. Comencemos con uno
        const datosOjiva = {
            label: "Frecuencia acumulada",
            data: [<?php echo $datosGraficafreq2 ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetaspoli
            backgroundColor: "rgb(255, 99, 132)", // Color de fondo
            fill: false,
            borderColor: 'purple',
            tension: 0.1
        };
        new Chart($graficaOjiva, {
            type: 'line', // Tipo de gráfica
            data: {
                labels: etiquetasOjiva,
                datasets: [
                    datosOjiva,
                    // Aquí más datos...
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                },
            }
        });
    </script>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</html>