<?php


namespace App;

class Codenation
{
    private $url = 'https://api.codenation.dev/v1/challenge/dev-ps';
    private $token = '';

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function sendAnswer()
    {
        try {
            if (!file_exists('answer.json')) {
                throw new \Error('Não foi possível encontrar o arquivo!');
            }

            $postfields = array();

            if (function_exists('curl_file_create')) {
                $file = curl_file_create('answer.json');
            } else {
                $file = '@' . realpath('answer.json');
            }

            $postfields['answer'] = $file;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url . '/submit-solution?token=' . $this->token);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Error(curl_error($ch));
            }

            curl_close($ch);

            return [
                'success' => true,
                'data' => $response
            ];
        } catch (\Throwable $exception) {
            return [
                'success' => false,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function getFileCifraCesar()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url . '/generate-data?token=' . $this->token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Error(curl_error($ch));
            }

            curl_close($ch);

            if (file_exists('answer.json')) {
                unlink('answer.json');
            }

            $fp = fopen('answer.json', 'w');
            fwrite($fp, $output);
            fclose($fp);

            $file = file_get_contents('answer.json');
            $data = json_decode($file, true);

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