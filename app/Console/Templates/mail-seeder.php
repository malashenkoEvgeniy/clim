namespace App\Modules\{ModuleName}\Database\Seeds;

use App\Core\Modules\Languages\Models\Language;
use App\Core\Modules\Mail\Models\MailTemplate;
use App\Core\Modules\Mail\Models\MailTemplateTranslates;
use Illuminate\Database\Seeder;

class {SeederName} extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = new MailTemplate();
        $template->name = '{TranslationsNamespace}::mail-templates.names.{MailAlias}';
        $template->alias = '{MailAlias}';
        $template->variables = {SeederVariables};
        $template->save();
        
        Language::all()->each(function (Language $language) use ($template) {
            $translate = new MailTemplateTranslates();
            $translate->language = $language->slug;
            $translate->row_id = $template->id;
            $translate->subject = '';
            $translate->text = '';
            $translate->save();
        });
    }
}
