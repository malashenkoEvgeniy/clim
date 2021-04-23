<?php

namespace App\Core;

/**
 * Trait AjaxTrait
 * Uses for controller with AJAXes or in API requests
 *
 * @package App\Core
 */
trait AjaxTrait
{
    
    /**
     * Answer in JSON for API
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonAnswer(array $data = [])
    {
        return response()->json($data);
    }
    
    /**
     * Success answer in JSON for API
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successJsonAnswer(array $data = [])
    {
        $data['success'] = true;
        return $this->jsonAnswer($data);
    }
    
    /**
     * Error answer in JSON for API
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorJsonAnswer(array $data = [])
    {
        $data['success'] = false;
        return $this->jsonAnswer($data);
    }
    
    /**
     * @param string $message
     * @param array $parameters
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    protected function successMfpMessage(string $message, array $parameters = [])
    {
        if (config('app.place') === 'site') {
            $template = view('site._widgets.popup.success', [
                'content' => $message,
            ])->render();
        } else {
            $template = $message;
        }
        return $this->successJsonAnswer([
            'mfpNoty' => $template,
        ] + $parameters);
    }
    
}
