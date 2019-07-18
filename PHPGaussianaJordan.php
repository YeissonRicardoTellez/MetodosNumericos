<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<style type="text/css">
    table, h1, h2, h3 {
      font-family: Arial, Helvetica, sans-serif;
    }
    table.Table {
      border: 1px solid #1C6EA4;
      background-color: #EEEEEE;
      width: 100%;
      text-align: left;
      border-collapse: collapse;
    }
    table.Table td, table.Table th {
      border: 1px solid #AAAAAA;
      padding: 3px 2px;
    }
    table.Table tbody td {
      font-size: 13px;
    }
    table.Table tr:nth-child(even) {
      background: #D0E4F5;
    }
    table.Table thead {
      background: #1C6EA4;
      background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
      background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
      background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
      border-bottom: 2px solid #444444;
    }
    table.Table thead th {
      font-size: 15px;
      font-weight: bold;
      color: #FFFFFF;
      border-left: 2px solid #D0E4F5;
    }
    table.Table thead th:first-child {
      border-left: none;
    }

    table.Table tfoot {
      font-size: 14px;
      font-weight: bold;
      color: #FFFFFF;
      background: #D0E4F5;
      background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
      background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
      background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
      border-top: 2px solid #444444;
    }
    table.Table tfoot td {
      font-size: 14px;
    }
    table.Table tfoot .links {
      text-align: right;
    }
    table.Table tfoot .links a{
      display: inline-block;
      background: #1C6EA4;
      color: #FFFFFF;
      padding: 2px 8px;
      border-radius: 5px;
    }
</style>
</head>
<body>
<pre>
<?php
$matriz = array(
        array(0,2,0,1),
        array(2,2,3,2),
        array(4,-3,0,1),
        array(6,1,-6,-5)
    );
$multiplos = array(0,-2,-7,6);

Gaussiana_Jordan($matriz, $multiplos);
function Gaussiana_Jordan($matriz, $C){
    //Valida y Genera Pivoteo 
    generar_table($matriz, "Matriz Inicial");
    $cant = count($matriz);

    for($i=0; $i<$cant; $i++){
        $matriz[$i][] = $C[$i];
    }
    $cant_col = $cant + 1;

    $f_mayor = 0;
    $v_mayor = 0;
    for($i=0; $i<$cant; $i++){
        if($v_mayor < abs($matriz[$i][0])){
            $v_mayor = $matriz[$i][0];
            $f_mayor = $i;
        }
    }
    $tmp_matriz = $matriz;
    $tmp_matriz[0] = $matriz[ $f_mayor ];
    $tmp_matriz[$f_mayor] = $matriz[ 0 ];
    if($f_mayor > 0){
        generar_table($tmp_matriz, "Se genero el Pivoteo de la Fila 1 por la Fila ".($f_mayor+1));
    }    
    for($i=0; $i<$cant; $i++){
        if($tmp_matriz[$i][$i]<>0){
            $num_div = $tmp_matriz[$i][$i];
            for($j=0; $j<$cant_col; $j++){
                $tmp_matriz[$i][$j] = ($tmp_matriz[$i][$j] / $num_div);
            }    
            generar_table($tmp_matriz, "Se Dividio la Fila ".($i+1)." Sobre ".round($num_div, 2));
        }
        for($j=($i+1); $j<$cant; $j++){
            if($tmp_matriz[$j][$i] <> 0){
                $num_mult = $tmp_matriz[$j][$i];
                for($k=0; $k<$cant_col; $k++){
                    $tmp_matriz[$j][$k] = $tmp_matriz[$j][$k] - ($tmp_matriz[$i][$k] * $num_mult);
                }
                generar_table($tmp_matriz, "Multiplicamos la Fila ".($i+1)." Por ".round($num_mult, 2)." y la Restamos a la Fila ".($j+1)."");
            }
        }
        for($j=($i-1); $j>=0; $j--){
            if($tmp_matriz[$j][$i] <> 0){
                $num_mult = $tmp_matriz[$j][$i];
                for($k=0; $k<$cant_col; $k++){
                    $tmp_matriz[$j][$k] = $tmp_matriz[$j][$k] - ($tmp_matriz[$i][$k] * $num_mult);
                }
                generar_table($tmp_matriz, "Multiplicamos la Fila ".($i+1)." Por ".round($num_mult, 2)." y la Restamos a la Fila ".($j+1)."");
            }
        }

    }
    for($j=0; $j<$cant; $j++){
        echo "<h2>De la Ecuación ".($j+1)." encontramos con la Variable X<sub>".($j+1)."</sub></h2>";
        echo "<h3>&emsp;&emsp;X<sub>".($j+1)."</sub> = ".round($tmp_matriz[$j][($cant_col-1)] , 2)."</h3>";
    }
    echo "<h2>La Respuesta es:</h2>";
    for($j=0; $j<$cant; $j++){
        echo "<h3>&emsp;&emsp;X<sub>".($j+1)."</sub> = ".round($tmp_matriz[$j][($cant_col-1)] , 2)."</h3>";
    }
}

function generar_table($array, $titulo = ""){
    $html = '<br><table class="Table" border="1"  style="width: 500px">';
    if($titulo != ""){
        $tot_colm = count($array[0]);
        $html .= "<thead>
                    <tr><th colspan='{$tot_colm}'>{$titulo}</th></tr>
                </thead>";
    }
    $html .= "<tbody>";
    $width = (100 / $tot_colm);
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td width="'.$width.'%">' . round($value2,2) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    echo $html;
}
?>
</pre>
</body>
</html>
