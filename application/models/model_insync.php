<?php

/**
 * User: sasha
 * Date: 09.08.18
 * Time: 14:05
 */
class Model_Insync extends Model
{

//    const PATH = 'http://93.84.121.106/ibsvc/api/transferLink';
    const PATH = 'https://chat.alfabank.by/ibsvc/api/transferLink';

    function getInfoByTransferId($tranfserLinkId)
    {
        $result = $this->getDataFromMiddle(["transferLinkId" => $tranfserLinkId], self::PATH . "/info");

        return $result;
    }


    function sendInfoByIncrement($transferLinkId)
    {
        $this->getDataFromMiddle(["transferLinkId" => $transferLinkId], self::PATH . "/userIncrement");
    }


    protected function getDataFromMiddle($param = [], $path)
    {
        $curl = @curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type:application/json"]);
        curl_setopt($curl, CURLOPT_URL, $path);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode( $param ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $out = curl_exec($curl);
        $result = json_decode($out, true);
        curl_close($curl);

        return $result;

    }

}