<?php

namespace App\Modules\Orders\Types;

/**
 * Class StepOneType
 *
 * @package App\Modules\Orders\Types
 */
class StepOneType
{
    
    /**
     * Client name
     *
     * @var mixed
     */
    public $name;
    
    /**
     * Client city
     *
     * @var mixed
     */
    public $city;
    
    /**
     * Client email
     *
     * @var mixed
     */
    public $email;
    
    /**
     * Client phone number
     *
     * @var mixed
     */
    public $phone;
    
    /**
     * locationId from nova poshta
     *
     * @var string
     */
    public $locationId;
    
    /**
     * StepOneType constructor.
     *
     * @param array $information
     */
    public function __construct(array $information)
    {
        $this->city = array_get($information, 'city');
        $this->name = array_get($information, 'name');
        $this->phone = array_get($information, 'phone');
        $this->email = array_get($information, 'email');
        $this->locationId = array_get($information, 'locationId');
    }
    
    /**
     * Returns area
     *
     * @return null|string
     */
    public function area(): ?string
    {
        return $this->city;
    }
    
}
