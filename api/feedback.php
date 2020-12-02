<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");

use Bitrix\Main\Application;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Web\Json;

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

class SendForm
{
    public static function run()
    {
        $token = "QiWMJNi9MSIOsOZ6";
        $result = array();
        $error = false;

        $rawBody = file_get_contents('php://input');
        if (!$rawBody) {
            ShowError('Нет данных');
            return;
        }

        if ($rawBody) {
            $postData = \Bitrix\Main\Web\Json::decode($rawBody);

            // здесь должна быть авторизация / антиспам и тд
            if ($postData['token'] == $token) {
                // проводим валидацию номера перед записью в инфоблок, 11 знаков, начинается с +7
                $phone = preg_replace('/[^0-9]/', '', $postData['phone']);
                if (strlen($phone) == 11) {
                    $phone = substr_replace($phone, '7', 0, 1);
                    $phone = '+' . $phone; // телефон должен начинаться с +7 (звонки по РФ)
                    $name = (strlen($postData['name']) > 0) ? $postData['name'] : 'Пользователь не указал имя';

                    CModule::IncludeModule('iblock');
                    $feedback = new CIBlockElement;

                    $arProps = array();
                    $arProps[4] = $phone;

                    $arFeedbackData = array(
                        "IBLOCK_SECTION_ID" => false,
                        "IBLOCK_ID" => 3,
                        "PROPERTY_VALUES" => $arProps,
                        "NAME" => $name,
                        "ACTIVE" => "Y",
                    );

                    if ($PRODUCT_ID = $feedback->Add($arFeedbackData)) {
                        $result['data']['fields']['name'] = $name;
                        $result['data']['fields']['phone'] = $phone;
                    } else
                        $error = "Ошибка добавления элемента в инфоблок";


                } else {
                    $error = "Неподходящий формат номера телефона, используйте формат вида +7 (000) 000-00-00";
                }
            } else {
                $error = "incorrect token";
            }
        }

        self::returnJson(array_merge([
            'result' => $error === false ? 'ok' : 'error',
            'error' => $error,
        ], $result));
    }

    private static function returnJson($data)
    {
        global $APPLICATION;
        $APPLICATION->restartBuffer();
        header('Content-Type: application/json; charset=UTF-8');
        echo \Bitrix\Main\Web\Json::encode($data);
    }
}

SendForm::run();

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php';