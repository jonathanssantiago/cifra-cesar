<?php

namespace App\Helpers;

class StringHelper
{
    public static function clearText($string = '')
    {
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ+'), 'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy-');
        return strtolower($string);
    }

    /**
     * Retorna a posição de cada letra dentro de um determinado array
     *
     * @param $values
     * @param $array
     * @return array
     */
    public static function getIndexesInArray($values, $array)
    {
        $data = [];

        if(!is_array($values)){
            $values = str_split($values);
        }

        for ($i = 0; $i < count($values); $i++) {
            if ($values[$i] == in_array($values[$i], $array)) {
                foreach ($array as $key => $value) {
                    if ($values[$i] == $value) {
                        $data[$value] = $key;
                    }
                }
            }
        }
        return $data;
    }
}