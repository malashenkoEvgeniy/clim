namespace App\Modules\{ModuleName}\Listeners;

use App\Core\Modules\Mail\Models\MailTemplate;
use App\Modules\{ModuleName}\Events\{RelatedEventName};
use App\Components\Mailer\MailSender;

/**
 * Class {ListenerName}
 *
 * @package App\Modules\{ModuleName}\Listeners
 */
class {ListenerName}
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Handle the event.
     *
     * @param {RelatedEventName} $event
     * @return void
     */
    public function handle({RelatedEventName} $event)
    {
        $template = MailTemplate::getTemplateByAlias('{MailAlias}');
        if (!$template) {
            return;
        }
        $from = [{ListenerVariablesKeys}];
        $to = [{ListenerVariablesValues}];
        $subject = str_replace($from, $to, $template->current->subject);
        $body = str_replace($from, $to, $template->current->text);
        MailSender::send($event->email, $subject, $body);
    }
}