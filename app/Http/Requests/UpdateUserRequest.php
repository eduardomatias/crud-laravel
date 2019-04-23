<?php

namespace App\Http\Requests;

class UpdateUserRequest extends BaseRequest
{
    
    /** @var string Related model */
    protected $modelRequest = 'App\Models\User';

    /**
     * Get attributes name.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->modelRequest::$attributeLabel;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->rulesRequiredOff($this->modelRequest::rules($this->getIdRules()));
    }
    
    /**
     * Runs before validating the request.
     *
     * @param Request $request
     * @return void
     */
    public function beforeValidator($request)
    {
        
    }
    
}
