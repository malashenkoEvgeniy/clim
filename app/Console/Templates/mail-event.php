namespace App\Modules\{ModuleName}\Events;

/**
 * Class {EventName}
 *
 * @package App\Modules\{ModuleName}\Events
 */
class {EventName}
{
    /**
     * @var string
     */
    public $email;{EventProperties}
    
    /**
     * Create a new event instance.
     *
     * @param string $email{EventPropertiesPhpDoc}
     * @return void
     */
    public function __construct(string $email{EventPropertiesList})
    {
        $this->email = $email;{SetEventProperties}
    }
}