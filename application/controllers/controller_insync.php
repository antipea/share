<?php

class Controller_Insync extends Controller
{

    const STORE_ID = '591881877';
    const SECRET_KEY = 'hjdpUJU78322-=';
    const WEBPAY_URL = 'https://payment.webpay.by/services';


    function __construct()
    {
        $this->model = new Model_Insync();
        $this->view = new View();
    }


    function action_index()
    {
        $data = $this->getMiddleData();

        if (empty($data) || !$data["accountIBAN"]) {
            Route::ErrorPage404();
        }

        $this->view->generate('insync_view.php', 'template_view.php', $data);
    }

    function action_send()
    {

        $middleData = $this->getMiddleData();

        if (empty($middleData) || !$middleData["accountIBAN"]) {
            Route::ErrorPage404();
        }

        $userFormData = $this->getUserFormData();
        $userFormErrors = $this->validateUserFormData($userFormData);


        $resultUserData = array_merge($middleData, $userFormData);

        if (!empty($userFormErrors)) {
            $this->view->generate('insync_view.php', 'template_view.php',
                array_merge($resultUserData, ['errors' => $userFormErrors]));

            return;
        }

        switch ($userFormData["submitForm"]) {
            case 'insync':
                $this->view->generate('submitinsync_view.php', 'template_view.php',
                    array_merge($resultUserData));
                break;
            case 'bank':
                $fieldsWebpay = $this->prepareFieldsWebpay($resultUserData);
                $this->view->generate('webpay_view.php', 'template_view.php',
                    array_merge($resultUserData, ["webpay" => $fieldsWebpay, 'webpay_url' => self::WEBPAY_URL]));
                break;
        }

        $this->sendIncrement($resultUserData);


    }


    protected function sendIncrement($resultData)
    {
        $this->model->getInfoByTransferId($resultData["transferLinkId"]);
    }

    protected function prepareFieldsWebpay($dataUser)
    {
        $constData = [
            "wsb_storeid"           => self::STORE_ID,
            "secret_key"            => self::SECRET_KEY,
            "wsb_invoice_item_name" => "Пополнение счета",
            "wsb_service_number"    => "4439061",
        ];

        $dataUser['sum'] = str_replace(",", ".", preg_replace("/\s/", "", $dataUser["sum"]));

        $dataWebpay = [
            "wsb_storeid"                 => $constData['wsb_storeid'],
            "wsb_store"                   => $dataUser["accountIBAN"],
            "wsb_order_num"               => time(),
            "wsb_currency_id"             => "BYN",
            "wsb_version"                 => "2",
            "wsb_language_id"             => "russian",
            "wsb_invoice_item_name[]"     => $constData["wsb_invoice_item_name"],
            "wsb_invoice_item_quantity[]" => "1",
            "wsb_invoice_item_price[]"    => $dataUser['sum'],
            "wsb_total"                   => $dataUser['sum'],
            "wsb_email"                   => "",
            "wsb_test"                    => "",
            "wsb_seed"                    => microtime(),
            "wsb_service_number"          => $constData["wsb_service_number"],
            "wsb_order_tag"               => "SITE-" . $constData["wsb_service_number"],
            "wsb_service_account"         => $dataUser["accountIBAN"],
        ];

        $dataWebpay['wsb_signature'] = sha1($dataWebpay["wsb_seed"] . $dataWebpay["wsb_storeid"] . $dataWebpay["wsb_order_num"] . $dataWebpay["wsb_test"] . $dataWebpay["wsb_currency_id"] . $dataWebpay["wsb_total"] . $dataWebpay["wsb_service_number"] . $dataWebpay["wsb_service_account"] . $constData["secret_key"]);

        return $dataWebpay;
    }

    protected function validateUserFormData($userFormData)
    {
        $errors = [];
        $validateFunc = [
            'sum' => function ($val) {
                return $val >= 1;
            },
        ];

        $errorMessages = [
            "sum" => "Минимум 1 BYN",
        ];

        foreach ($userFormData as $itemKey => $itemVal) {
            if (!isset($validateFunc[ $itemKey ]) || $validateFunc[ $itemKey ]($itemVal)) {
                continue;
            }
            $errors[ $itemKey ] = $errorMessages[ $itemKey ] ?: "Ошибка";
        }


        return $errors;
    }

    protected function getUserFormData()
    {
        $postKeys = ['sum', 'submitForm'];
        $prepareFunc = [
            'sum' => function ($val) { $val = str_replace(",", ".", $val); return floatval($val); },
        ];

        $data = [];
        foreach ($postKeys as $itemKey) {
            $itemVal = $_POST[ $itemKey ];
            if (isset($prepareFunc[ $itemKey ])) {
                $itemVal = $prepareFunc[ $itemKey ]($itemVal);
            }
            $data[ $itemKey ] = $itemVal;
        }
        return $data;
    }

    protected function getMiddleData()
    {
        $transferLinkId = $_REQUEST["transferLinkId"];
        $data = (array)$this->model->getInfoByTransferId($transferLinkId);
        $data['transferLinkId'] = $transferLinkId;

        return $data;
    }
}