<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Codenation;
use App\CriptografiaCesar;

$codenation = new Codenation('8ad7289ab63f20e7798cb2060e7577742a5224b5');

$getDataFile = $codenation->getFileCifraCesar();

if (isset($getDataFile['success']) && $getDataFile['success']) {
    $cifra = $getDataFile['data']['cifrado'];
    $nro_casas = $getDataFile['data']['numero_casas'];

    $criptografiaCesar = new CriptografiaCesar($cifra);
    $response = $criptografiaCesar->decrypt($nro_casas);


    if(isset($response['success']) && $response['success']){
        $answerFile = file_get_contents('answer.json');
        $jsonAnswer = json_decode($answerFile, true);

        $jsonAnswer['decifrado'] = $response['data'];
        $jsonAnswer['resumo_criptografico'] = sha1($response['data']);

        $newJsonAnswer = json_encode($jsonAnswer);
        file_put_contents('answer.json', $newJsonAnswer);

        $codenation->sendAnswer();
    }
}
