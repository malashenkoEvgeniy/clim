<?php

namespace App\Components\Delivery;

use NovaPoshta\ApiModels\Common;
use Lang, Cache;

/**
 * Class NovaPoshta
 *
 * @package App\Components\Delivery
 */
class NovaPoshta
{
    private $apiUrl = 'https://api.novaposhta.ua/v2.0/json/';
    private $apiKey;
    private $city = null;
    private $region = null;
    private $lang = null;

    /**
     * NovaPoshta constructor.
     * @param null $location
     */
    public function __construct($location = null)
    {
        $this->apiKey = config('db.nova-poshta.key');
        $this->lang = Lang::getLocale();
        if (isset($location)) {
            $this->setLocation($location);
        }
    }

    /**
     * @param $query
     * @return bool|mixed
     */
    public function searchSettlements($query)
    {
        $data = [
            "modelName" => "Address",
            "calledMethod" => "searchSettlements",
            "apiKey" => $this->apiKey,
            "methodProperties" => [
                "Language" => $this->lang,
                "CityName" => $query,
                "Limit" => 15,
            ],
        ];
        return $this->sendCurl($data, true);
    }

    /**
     * @return bool|mixed
     */
    public function getCities()
    {
        $data = [
            "modelName" => "Address",
            "calledMethod" => "getCities",
            "apiKey" => $this->apiKey,
        ];
        return Cache::remember('nova-poshta-cities', 1440, function () use ($data) {
            return $this->sendCurl($data);
        });
    }

    /**
     * @param $city
     * @return array|bool|mixed
     */
    public function getWarehouses($city)
    {
        if (!isset($city)) {
            return [];
        }
        $city = explode(" ", $city);
        $city = array_pop($city);
        $data = [
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "Language" => $this->lang,
                "CityName" => $city,
            ],
            "apiKey" => $this->apiKey,
        ];
        return $this->sendCurl($data);
    }

    /**
     * @param $city
     * @return array|bool|mixed
     */
    public function getWarehousesCityRef($city)
    {
        if (!isset($city)) {
            return [];
        }
        $data = [
            "modelName" => "AddressGeneral",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "Language" => $this->lang,
                "CityRef" => $city,
            ],
            "apiKey" => $this->apiKey,
        ];
        return $this->sendCurl($data);
    }

    /**
     * @param $ref
     * @return mixed|null
     */
    public function getWarehouseInfo($ref): ?string
    {
        if (!isset($ref)) {
            return null;
        }
        $data = [
            "modelName" => "Address",
            "calledMethod" => "getWarehouses",
            "methodProperties" => [
                "Language" => $this->lang,
                "Ref" => $ref,
            ],
            "apiKey" => $this->apiKey,
        ];
    
        $response = $this->sendCurl($data, true);
        if ($response) {
            return array_get($response, 'data.0.DescriptionRu');
        }
        return null;
    }

    /**
     * @param $location
     * @return bool
     */
    public function setLocation($location)
    {
        $location = explode(',', $location);
        $this->city = trim(array_shift($location));
        if (count($location)) {
            $this->region = trim(implode(',', $location));
        }
        return true;
    }

    /**
     * @return null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return null
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param $ttn
     * @return array|bool|mixed
     */
    public function getDeliveryInformationByTTN($ttn)
    {
        if (!isset($ttn)) {
            return [];
        }
        $data = [
            "modelName" => "TrackingDocument",
            "calledMethod" => "getStatusDocuments",
            "methodProperties" => [
                'Documents' => [
                    [
                        "DocumentNumber" => $ttn,
                        "Phone" => ''
                    ]
                ]
            ],
            "apiKey" => $this->apiKey,
        ];

        return $this->sendCurl($data);
    }

    /**
     * @param $data
     * @param bool $array
     * @return bool|mixed
     */
    public function sendCurl($data, $array = false)
    {
        $data = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("content-type: application/json"));
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return false;
        } else {
            return json_decode($response, $array);
        }
    }
    
    public static function getCargoTypes()
    {
        return Cache::remember('nova-poshta-cargo-types', 1440, function () {
            return Common::getCargoTypes()->data;
        });
    }
    
    public static function getCargoDescriptionList()
    {
        return Cache::remember('nova-poshta-cargo-description-list', 1440, function () {
            return Common::getCargoDescriptionList()->data;
        });
    }
    
    public static function getPaymentForms()
    {
        return Cache::remember('nova-poshta-payment-forms', 1440, function () {
            return Common::getPaymentForms()->data;
        });
    }
    
    public static function getTypesOfPayers()
    {
        return Cache::remember('nova-poshta-types-of-payers', 1440, function () {
            return Common::getTypesOfPayers()->data;
        });
    }
    
    public static function getServiceTypes()
    {
        return Cache::remember('nova-poshta-service-types', 1440, function () {
            return Common::getServiceTypes()->data;
        });
    }
}
