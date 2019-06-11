<?php

namespace App;

use App\Helpers\StringHelper;

class CriptografiaCesar
{

    protected $alfabeto = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', ' ', '.'];
    protected $tamanhoAlfabeto = 0;
    public $string = ' ';

    public function __construct($string)
    {
        $this->string = $string;
        $this->tamanhoAlfabeto = count($this->alfabeto) - 2;
    }

    public function decrypt($nro_casas = 0)
    {
        try {
            if (!$this->string) {
                throw new \Error('É necesário informar uma sentença!');
            }
            $data = '';

            $text = StringHelper::clearText($this->string);
            $sentencaSplit = str_split($text);

            $posicaoAlfabeto = StringHelper::getIndexesInArray($sentencaSplit, $this->alfabeto);

            if (count($posicaoAlfabeto) == 0) {
                throw new \Error('Não foi possível encontrar as letras da sentença no alfabeto.');
            }

            for ($j = 0; $j < count($sentencaSplit); $j++) {
                $posicao = $posicaoAlfabeto[$sentencaSplit[$j]]; // pega a posição de cada letra

                if ($posicao == '26') {
                    $data .= ' ';
                } else if ($posicao == '27') {
                    $data .= '.';
                } else {
                    $posicaoCesar = $posicao - $nro_casas;

                    if ($posicaoCesar < 0) {
                        $data .= $this->alfabeto[$posicaoCesar + $this->tamanhoAlfabeto];
                    } else if ($posicaoCesar > $this->tamanhoAlfabeto - 1) {
                        $data .= $this->alfabeto[$posicaoCesar - $this->tamanhoAlfabeto];
                    } else {
                        $data .= $this->alfabeto[$posicaoCesar];
                    }
                }
            }

            return [
                'success' => true,
                'data' => $data
            ];
        } catch (\Throwable $exception) {

            return [
                'success' => false,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function crypt($nro_casas = 0)
    {
        try {
            if (!$this->string) {
                throw new \Error('É necesário informar uma sentença!');
            }
            $data = '';

            $text = StringHelper::clearText($this->string);
            $sentencaSplit = str_split($text);

            $posicaoAlfabeto = StringHelper::getIndexesInArray($sentencaSplit, $this->alfabeto);

            if (count($posicaoAlfabeto) == 0) {
                throw new \Error('Não foi possível encontrar as letras da sentença no alfabeto.');
            }

            for ($j = 0; $j < count($sentencaSplit); $j++) {
                $posicao = $posicaoAlfabeto[$sentencaSplit[$j]]; // pega a posição de cada letra

                if ($posicao == '26') {
                    $data .= ' ';
                } else if ($posicao == '27') {
                    $data .= '.';
                } else {
                    $posicaoCesar = $posicao + $nro_casas;

                    if ($posicaoCesar < 0) {
                        $data .= $this->alfabeto[$posicaoCesar + $this->tamanhoAlfabeto];
                    } else if ($posicaoCesar > $this->tamanhoAlfabeto - 1) {
                        $data .= $this->alfabeto[$posicaoCesar - $this->tamanhoAlfabeto];
                    } else {
                        $data .= $this->alfabeto[$posicaoCesar];
                    }
                }
            }

            return [
                'success' => true,
                'data' => $data
            ];
        } catch (\Throwable $exception) {

            return [
                'success' => false,
                'error' => $exception->getMessage()
            ];
        }
    }
}