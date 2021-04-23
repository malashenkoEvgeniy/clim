<?php

namespace App\Core\Modules\Mail\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\Mail\Models\MailTemplateTranslates
 *
 * @property int $id
 * @property string $subject
 * @property string $text
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Core\Modules\Mail\Models\MailTemplate $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates whereRowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Mail\Models\MailTemplateTranslates whereText($value)
 * @mixin \Eloquent
 */
class MailTemplateTranslates extends Model
{
    use ModelTranslates;
    
    protected $table = 'mail_templates_translates';
    
    public $timestamps = false;
    
    protected $fillable = ['subject', 'text'];
    
}
