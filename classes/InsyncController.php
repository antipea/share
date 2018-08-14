<?php
/**
 * User: sasha
 * Date: 09.08.18
 * Time: 11:57
 */

include "MiddleHelper.php";

class InsyncController
{

    protected $transferLinkId;

    function __construct()
    {
        $this->transferLinkId = $_POST["transferLinkId"];
    }


    function execute()
    {
        if (empty($this->transferLinkId)) {

        }

        $middleObj = new MiddleHelper();
        $transferInfo = $middleObj->getInfoByTransferId($this->transferLinkId);


    }


}