<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Components\Delivery\NovaPoshta;

/**
 * Class GenerateTtnRequest
 *
 * @package App\Modules\Orders\Requests
 */
class GenerateTtnRequest extends FormRequest implements RequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $npLocationsRegex = '/^[0-9a-z]{8}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{12}$/';
        $phoneRegex = '/^\+380[0-9]{9}$/';
        $cargoTypes = [];
        foreach (NovaPoshta::getCargoTypes() as $key => $types) {
            $cargoTypes[] = $types->Ref;
        }
        $cargoDescription = [];
        foreach (NovaPoshta::getCargoDescriptionList() as $key => $types) {
            $cargoDescription[] = $types->Description;
        }
        $paymentForms = [];
        foreach (NovaPoshta::getPaymentForms() as $key => $types) {
            $paymentForms[] = $types->Ref;
        }
        $typesOfPayers = [];
        foreach (NovaPoshta::getTypesOfPayers() as $key => $types) {
            $typesOfPayers[] = $types->Ref;
        }
        $serviceTypes = [];
        foreach (NovaPoshta::getServiceTypes() as $key => $types) {
            $serviceTypes[] = $types->Ref;
        }
        return [
            'senderLastName' => ['required', 'string', 'min:2', 'max:191'],
            'senderFirstName' => ['required', 'string', 'min:2', 'max:191'],
            'senderMiddleLame' => ['required', 'string', 'min:2', 'max:191'],
            'senderPhone' => ['required', 'string', 'regex:' . $phoneRegex],
            'senderCity' => ['required', 'string', 'regex:' . $npLocationsRegex],
            'senderWarehouses' => ['required', 'string', 'regex:' . $npLocationsRegex],
            
            'recipientLastName' => ['required', 'string', 'min:2', 'max:191'],
            'recipientFirsName' => ['required', 'string', 'min:2', 'max:191'],
            'recipientMiddleName' => ['required', 'string', 'min:2', 'max:191'],
            'recipientPhone' => ['required', 'string', 'regex:' . $phoneRegex],
            'recipientCity' => ['required', 'string', 'regex:' . $npLocationsRegex],
            'recipientWarehouses' => ['required', 'string', 'regex:' . $npLocationsRegex],
            
            'delivery' => ['required', Rule::in($cargoTypes)],
            'weight' => ['required', 'numeric'],
            'volumeGeneral' => ['required', 'numeric'],
            'cost' => ['required', 'integer'],
            'description' => ['required', Rule::in($cargoDescription)],
            'packingNumber' => ['required', 'integer'],
            'preferredDeliveryDate' => ['required', 'date'],
    
            'payerType' => ['required', Rule::in($typesOfPayers)],
            'paymentMethod' => ['required', Rule::in($paymentForms)],
            
            'serviceType' => ['required', Rule::in($serviceTypes)],
        ];
    }
    
}
