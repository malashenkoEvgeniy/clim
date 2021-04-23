<?php

namespace App\Components\Payments\Services;

use App\Exceptions\WrongParametersException;

/**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        LiqPay
 * @package         liqpay/liqpay
 * @version         3.0
 * @author          Liqpay
 * @copyright       Copyright (c) 2014 Liqpay
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * LIQPAY API       https://www.liqpay.com/ru/doc
 *
 */
class LiqPay
{
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';
    const CURRENCY_UAH = 'UAH';
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_RUR = 'RUR';

    private $_api_url = 'https://www.liqpay.ua/api/';
    private $_checkout_url = 'https://www.liqpay.ua/api/3/checkout';

    protected $_supportedCurrencies = array(
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
        self::CURRENCY_UAH,
        self::CURRENCY_RUB,
        self::CURRENCY_RUR,
    );

    private $_public_key;
    private $_private_key;
    private $_server_response_code = null;

    private $_test = false;

    public $statuses = [
        'success' => 'Успешный платеж',
        'failure' => 'Неуспешный платеж',
        'wait_secure' => 'Платеж на проверке',
        'wait_accept' => 'Деньги с клиента списаны, но магазин еще не прошел проверку',
        'wait_lc' => 'Аккредитив. Деньги с клиента списаны, ожидается подтверждение доставки товара',
        'processing' => 'Платеж обрабатывается',
        'sandbox' => 'Тестовый платеж',
        'subscribed' => 'Подписка успешно оформлена',
        'unsubscribed' => 'Подписка успешно деактивирована',
        'reversed' => 'Возврат клиенту после списания',
    ];

    /**
     * LiqPay constructor.
     *
     * @throws WrongParametersException
     */
    public function __construct()
    {
        $this->_public_key = config('db.liqpay.public-key');
        $this->_private_key = config('db.liqpay.private-key');
        $this->_test = (bool)config('db.liqpay.test', false);
        if (!$this->_public_key) {
            throw new WrongParametersException('public_key is empty');
        }
        if (!$this->_private_key) {
            throw new WrongParametersException('private_key is empty');
        }
    }

    /**
     * Return last api response http code
     *
     * @return string|null
     */
    public function get_response_code()
    {
        return $this->_server_response_code;
    }

    /**
     * Call API
     *
     * @param $path
     * @param array $params
     * @return mixed
     * @throws WrongParametersException
     */
    public function api($path, $params = [], $timeout = 5)
    {
        if (!isset($params['version'])) {
            throw new WrongParametersException('version is null');
        }
        $url         = $this->_api_url . $path;
        $public_key  = $this->_public_key;
        $private_key = $this->_private_key;
        $data        = $this->encode_params(array_merge(compact('public_key'), $params));
        $signature   = $this->str_to_sign($private_key.$data.$private_key);
        $postfields  = http_build_query(array(
            'data'  => $data,
            'signature' => $signature
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Avoid MITM vulnerability http://phpsecurity.readthedocs.io/en/latest/Input-Validation.html#validation-of-input-sources
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);    // Check the existence of a common name and also verify that it matches the hostname provided
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,$timeout);   // The number of seconds to wait while trying to connect
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);          // The maximum number of seconds to allow cURL functions to execute
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $this->_server_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return json_decode($server_output);
    }


    /**
     * @param $params
     * @return string
     * @throws WrongParametersException
     */
    public function cnb_form($params)
    {
        $params = $this->cnb_params($params);
        $data = base64_encode(json_encode($params));
        $signature = $this->cnb_signature($params);
        return sprintf('
                <form method="POST" action="%s" accept-charset="utf-8" id="process-payment">
                    %s
                    %s
                </form>
                ',
            $this->_checkout_url,
            sprintf('<input type="hidden" name="%s" value="%s" />', 'data', $data),
            sprintf('<input type="hidden" name="%s" value="%s" />', 'signature', $signature)
        );
    }

    /**
     * @param $params
     * @return string
     * @throws WrongParametersException
     */
    public function cnb_signature($params)
    {
        $params = $this->cnb_params($params);
        $private_key = $this->_private_key;
        $json = base64_encode(json_encode($params));
        $signature = $this->str_to_sign($private_key . $json . $private_key);
        return $signature;
    }

    /**
     * @param array $params
     * @return array
     * @throws WrongParametersException
     */
    private function cnb_params(array $params = [])
    {
        $params['public_key'] = $this->_public_key;
        if (!isset($params['version'])) {
            throw new WrongParametersException('version is null');
        }
        if (!isset($params['amount'])) {
            throw new WrongParametersException('amount is null');
        }
        if (!isset($params['currency']) || !in_array($params['currency'], $this->_supportedCurrencies)) {
            $params['currency'] = 'UAH';
        }
        if ($params['currency'] == 'RUR') {
            $params['currency'] = 'RUB';
        }
        if (!isset($params['description'])) {
            throw new WrongParametersException('description is null');
        }
        if (!isset($params['action'])) {
            $params['action'] = 'pay';
        }
        $params['sandbox'] = (int)$this->_test;
        return $params;
    }

    /**
     * encode_params
     *
     * @param array $params
     * @return string
     */
    private function encode_params($params)
    {
        return base64_encode(json_encode($params));
    }
    /**
     * decode_params
     *
     * @param string $params
     * @return array
     */
    public function decode_params($params)
    {
        return json_decode(base64_decode($params), true);
    }

    /**
     * str_to_sign
     *
     * @param string $str
     * @return string
     */
    public function str_to_sign($str)
    {
        $signature = base64_encode(sha1($str, 1));
        return $signature;
    }

    /**
     * Valid incoming in server action data
     * @return bool
     */
    public function server_valid()
    {
        if (!isset($_POST['data']) || !isset($_POST['sign'])) {
            return false;
        }
        $sign = base64_encode(sha1($this->_private_key . $_POST['data'] . $this->_private_key, 1));
        if ($sign !== $_POST['sign']) {
            return false;
        }
        $json = base64_decode($_POST['data']);
        $data = json_decode($json);
        if (!is_array($data)) {
            return false;
        }
        if (!isset($data['version']) or $data['version'] != 3) {
            return false;
        }
        if (!isset($data['public_key']) or $data['public_key'] !== $this->_public_key) {
            return false;
        }
        if (!isset($data['order_id']) || !isset($data['status']) || !isset($this->statuses[$data['status']])) {
            return false;
        }

        // GET ORDER ROW HERE
        $order = mysql::query_one('SELECT * FROM order_number WHERE id = ' . $data['order_id']);
        if ($order->liqpay_status && !in_array($order->liqpay_status, ['wait_secure', 'wait_accept', 'wait_lc', 'processing'])) {
            return false;
        }

        // GET ITEMS FROM ORDER
        $items = mysql::query('SELECT * FROM orders WHERE number_order = ' . $data['order_id']);

        // GET COUNT OF GOODS, AMOUNT
        $amount = 0;
        $goods = 0;
        $amount += $order->cost_deliver;
        foreach ($items as $value) {
            $goods += $value->kolvo;
            $amount += $value->cost * $value->kolvo;
        }
        if (!isset($data['amount']) or $data['amount'] !== (float)number_format($amount, 2, '.', '')) {
            return false;
        }
        if (!isset($data['currency']) or $data['currency'] != 'USD') {
            return false;
        }

        // GENERATE DESCRIPTION
        $description = $goods . ' items for ' . number_format($amount - $order->cost_deliver, 2, '.', '') . ' USD + delivery for ' . number_format($order->cost_deliver, 2, '.', '') . ' USD';
        if (!isset($data['description']) or $data['description'] != $description) {
            return false;
        }

        return true;
    }

}
