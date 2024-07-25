<?php

namespace Arielfad\CufSiatBolivia;

class AuxiliaryMethods
{
    /***
     * Obtiene el modulo de la cadena concatenada inicialmente.
     * @param string $string
     * @param int $digit
     * @param int $limit
     * @param bool $decimal
     * @return string
     */
    public static function getModule11(string $string, int $digit, int $limit, bool $decimal): string
    {
        if (!$decimal) {
            $digit = 1;
        }
        for ($n = 1; $n <= $digit; $n++) {
            $soma = 0;
            $mult = 2;
            for ($i = strlen($string) - 1; $i >= 0; $i--) {
                $soma += ($mult * substr($string, $i, 1));
                if (++$mult > $limit) {
                    $mult = 2;
                }
            }
            if ($decimal) {
                $dig = (($soma * 10) % 11) % 10;
            } else {
                $dig = $soma % 11;
            }

            if ($dig == 10) {
                $string .= "1";
            }
            if ($dig == 11) {
                $string .= "0";
            }
            if ($dig < 10) {
                $string .= $dig;
            }
        }
        return substr($string, strlen($string) - $digit, $digit);
    }

    /***
     * Obtiene el módulo de un número de precisión arbitraria.
     * @param $x
     * @param $y
     * @return int
     */
    public static function getBcmod($x, $y)
    {
        $digit = 5;
        $module = '';
        do {
            $a = (int) $module . substr($x, 0, $digit);
            $x = substr($x, $digit);
            $module = $a % $y;
        } while (strlen($x));

        return (int) $module;
    }

    /***
     * Conversión de una cadena en base 16 (valores hexadecimales)
     * @param string $code
     * @param bool $touppercase
     * @return string
     */
    public static function getBase16(string $code, bool $touppercase = true): string
    {
        $hexadecimal = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
        $value = '';
        while ($code != '0') {
            $mode =  AuxiliaryMethods::getBcmod($code, '16');
            $value = $hexadecimal[$mode] . $value;
            $code = bcdiv($code, '16', 0);
        }
        return ($touppercase) ? strtoupper($value) : $value;
    }
}