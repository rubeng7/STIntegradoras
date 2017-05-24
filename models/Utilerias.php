<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of Utilerias
 *
 * @author ruben
 */
class Utilerias {

    public static function mapeaMeses() {
        return [
            '0' => 'Enero',
            '1' => 'Febrero',
            '2' => 'Marzo',
            '3' => 'Abril',
            '4' => 'Mayo',
            '5' => 'Junio',
            '6' => 'Julio',
            '7' => 'Agosto',
            '8' => 'Septiembre',
            '9' => 'Octubre',
            '10' => 'Noviembre',
            '11' => 'Diciembre',
        ];
    }

    public static function getNombreMes($numeroMes) {
        switch ($numeroMes) {
            case 0:
                return 'Enero';
            case 1:
                return 'Febrero';
            case 2:
                return 'Marzo';
            case 3:
                return 'Abril';
            case 4:
                return 'Mayo';
            case 5:
                return 'Junio';
            case 6:
                return 'Julio';
            case 7:
                return 'Agosto';
            case 8:
                return 'Septiembre';
            case 9:
                return 'Octubre';
            case 10:
                return 'Noviembre';
            case 11:
                return 'Diciembre';
            default :
                return 'Null';
        }
    }

    public static function getDateMysqlFromDateNormal($date) {
        $dateFormat = date_create_from_format('d/m/Y', $date);
        return date_format($dateFormat, 'Y-m-d');
    }

    public static function getDateNormalFromDateMysql($date) {
        $dateFormat = date_create_from_format('Y-m-d', $date);
        return date_format($dateFormat, 'd/m/Y');
    }

    public static function getPeriodo(Periodo $periodo) {
        $mesInicio = Utilerias::getNombreMes($periodo->mesInicio);
        $mesFin = Utilerias::getNombreMes($periodo->mesFin);
        $año = $periodo->anio;

        return $mesInicio . ' - ' . $mesFin . ' ' . $año;
    }

    public static function my_array_unique($array, $keep_key_assoc = false) {
        $duplicate_keys = [];
        $tmp = [];

        foreach ($array as $key => $val) {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array) $val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }

}
