<?php
/**
 * User: sasha
 * Date: 08.08.18
 * Time: 15:56
 */

class MiddleHelper
{
    const PATH = 'http://172.20.13.184:8480/webBankSILayer/api/transferLink/info';

    function getInfoByTransferId($tranfserLinkId)
    {
        $result = $this->getData(["transferLinkId" => $tranfserLinkId]);
        return $result;
    }

    function getData($param = [])
    {
        $curl = @curl_init();
        curl_setopt($curl, CURLOPT_URL, self::PATH);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $out = curl_exec($curl);
        $result = json_decode($out, true);
        curl_close($curl);

        return $result;

    }

}