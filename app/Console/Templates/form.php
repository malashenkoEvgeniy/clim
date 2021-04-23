namespace App\Modules\{ModuleName}\Forms;

use App\Core\Interfaces\FormInterface;{FullModelNamespace}
use CustomForm\Builder\Form;
use Illuminate\Database\Eloquent\Model;

/**
 * Class {FormName}
 *
 * @package App\Core\Modules\{ModuleName}\Forms
 */
class {FormName} implements FormInterface
{

    /**
     * @param  Model{ModelNameWithStem}|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {{ModelRegistration}
        $form = Form::create();
        // TODO integrate your form fields here
        return $form;
    }
    
}
