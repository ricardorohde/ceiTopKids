<?php

//echo CalcularIdade("17/08/2007","dma","/");
////Retorno: 7 meses e 17 dias
//echo CalcularIdade("2006-08-17","amd","-");
////Retorno: 1 ano, 7 meses e 17 dias

function CalcularIdade($nascimento, $formato, $separador) {
//    $nascimento = "2016-10-19";
//    $formato = "amd";
//    $separador = "-";
    //Data Nascimento
    $nascimento = explode($separador, $nascimento);

    if ($data1 > $data2) {
        return " ";
    }

    if ($formato == "dma") {
        $ano = $nascimento[2];
        $mes = $nascimento[1];
        $dia = $nascimento[0];
    } elseif ($formato == "amd") {
        $ano = $nascimento[0];
        $mes = $nascimento[1];
        $dia = $nascimento[2];
    }

    $dia1 = $dia;
    $mes1 = $mes;
    $ano1 = $ano;

    $dia2 = date("d");
    $mes2 = date("m");
    $ano2 = date("Y");

    $dif_ano = $ano2 - $ano1;
    $dif_mes = $mes2 - $mes1;
    $dif_dia = $dia2 - $dia1;

    if (($dif_mes == 0) and ( $dia2 < $dia1)) {
        $dif_dia = (ultimoDiaMes($data1) - $dia1) + $dia2;
        $dif_mes = 11;
        $dif_ano--;
    } elseif ($dif_mes < 0) {
        $dif_mes = (12 - $mes1) + $mes2;
        $dif_ano--;
        if ($dif_dia < 0) {
            $dif_dia = (ultimoDiaMes($data1) - $dia1) + $dia2;
            $dif_mes--;
        }
    } elseif ($dif_dia < 0) {
        $dif_dia = (ultimoDiaMes($data1) - $dia1) + $dia2;
        if ($dif_mes > 0) {
            $dif_mes--;
        }
    }
    if ($dif_ano > 0) {
        $dif_ano = $dif_ano . " ano" . (($dif_ano > 1) ? "s " : " ");
    } else {
        $dif_ano = "";
    }
    if ($dif_mes > 0) {
        $dif_mes = $dif_mes . " mes" . (($dif_mes > 1) ? "es " : " ");
    } else {
        $dif_mes = "";
    }
    if ($dif_dia > 0) {
        $dif_dia = $dif_dia . " dia" . (($dif_dia > 1) ? "s " : " ");
    } else {
        $dif_dia = "";
    }

    return $dif_ano . $dif_mes . $dif_dia;
}
