namespace App\Modules\{ModuleName}\Filters;

use CustomForm\Builder\Form;
use EloquentFilter\ModelFilter;

/**
* Class {FilterName}
*
* @package App\Core\Modules\{ModuleName}\Filters
*/
class {FilterName} extends ModelFilter
{
    /**
     * Generate form view
     *
     * @return string
     * @throws \App\Exceptions\WrongParametersException
     */
    static function showFilter()
    {
        $form = Form::create();
        // TODO place for your fields
        return $form->renderAsFilter();
    }
    
    // TODO put your filter methods here
}
