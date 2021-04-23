<?php

namespace App\Modules\Consultations\Controllers\Site;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Consultations\Models\Consultation;
use App\Modules\Consultations\Requests\SiteConsultationsRequest;

/**
 * Class ConsultationController
 *
 * @package App\Modules\Consultations\Controllers\Site
 */
class ConsultationController extends SiteController
{
    use AjaxTrait;
    
    /**
     * @param SiteConsultationsRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function send(SiteConsultationsRequest $request)
    {
        $consultation = new Consultation();
        $consultation->fill($request->all());
        if ($consultation->save()) {
            event('consultation::created', $consultation);
            event('consultation', $consultation);
            return $this->successMfpMessage(trans('consultations::general.message-success'), [
                'reset' => true
            ]);
        }
        return $this->errorJsonAnswer([
            'notyMessage' => trans('consultations::general.message-false'),
        ]);
    }
    
}
