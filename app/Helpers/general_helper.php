<?php


function dias_numerico_literal($dia_numero)
{
    $dia_numero = (int) $dia_numero;
    $dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
    $dia_semana = $dias_semana[($dia_numero - 1) % 7];

    return $dia_semana;
}

function crear_rango($dias_semana)
{
    // Obtener la fecha actual
    $hoy = time();

    // Definir el número de segundos en un día
    $segundos_dia = 86400;

    // Definir el número de meses a generar
    $num_meses = 1;

    // Obtener la fecha dentro de dos meses
    $fecha_limite = strtotime("+{$num_meses} months", $hoy);

    // Inicializar un arreglo para almacenar las fechas
    $fechas = array();

    // Iterar por cada día en el rango de fechas deseado
    for ($fecha_actual = $hoy; $fecha_actual < $fecha_limite; $fecha_actual += $segundos_dia) {
        // Obtener el día de la semana actual
        $dia_semana_actual = date('N', $fecha_actual);

        // Si el día de la semana actual está en el arreglo, agregar la fecha a la lista
        if (in_array($dia_semana_actual, $dias_semana)) {
            $fechas[] = date('m/d/Y', $fecha_actual);
        }
    }

    return $fechas;
}

function getFormatoFechaD_M_Y($dateTime)
{
    $fecha = new DateTime($dateTime);
    $fecha = $fecha->format('d/m/Y');
    if ($fecha == "01/01/1900" || $fecha == "01/01/0001" || $dateTime == "0000-00-00") {
        $fecha = "";
    }
    return ($fecha);
}

function getFormatoFechaH_M($dateTime)
{
    $fecha = new DateTime($dateTime);
    $fecha = $fecha->format('H:i');
    return ($fecha);
}

function getFormatoFechaD_M_Y_H_M($dateTime)
{
    $fecha = new DateTime($dateTime);
    $fecha = $fecha->format('d/m/Y H:i');
    if ($fecha == "01/01/1900T00:00:00" || $fecha == "01/01/0001T00:00:00") {
        $fecha = "";
    }
    return ($fecha);
}

function getFormatoFechaD_M_Y_H_M_S($dateTime)
{
    $fecha = new DateTime($dateTime);
    $fecha = $fecha->format('d/m/Y H:i:s');
    if ($fecha == "01/01/1900T00:00:00" || $fecha == "01/01/0001T00:00:00") {
        $fecha = "";
    }
    return ($fecha);
}

function generarColorAleatorio()
{
    $rojo = mt_rand(0, 255);
    $verde = mt_rand(0, 255);
    $azul = mt_rand(0, 255);

    $color = "rgb($rojo, $verde, $azul, 0.2)";

    return $color;
}


function getNombreRol($rol_id)
{
    $rol_nombre = "";
    switch ($rol_id) {
        case "1";
            $rol_nombre = "Gerente General - ";
            break;
        case "2";
            $rol_nombre = "Administrador - ";
            break;
        case "3";
            $rol_nombre = "Operador - ";
            break;
        case "4";
            $rol_nombre = "Instructor - ";
            break;
        case "5";
            $rol_nombre = "Cliente - ";
            break;
        default:
            $rol_nombre = "";
            break;
    }
    return $rol_nombre;
}


function MapSucursal($sucursales)
{
    $lista_sucursales = [];

    foreach ($sucursales as $value) {
        $estado = $value["sucursal_activo"] == 1 ? "Activo" : "Inactivo";
        $lista_sucursales[] = [
            "sucursal_id" => $value["sucursal_id"],
            "sucursal_nombre" => $value["sucursal_nombre"],
            "sucursal_activo" => $value["sucursal_activo"],
            "estado" => $estado
        ];
    }

    return $lista_sucursales;
}


function verificarSucursales($cad1, $cad2)
{
    $arrayCad1 = explode(',', $cad1);
    $arrayCad2 = explode(',', $cad2);

    foreach ($arrayCad1 as $valor) {
        if (in_array($valor, $arrayCad2)) {
            return true;
        }
    }

    return false;
}


function Logger($data)
{
    $resultado = json_encode($data);
    $archivo = fopen("resultados.json", "a");
    fwrite($archivo, $resultado . "\n");
    fclose($archivo);
}
