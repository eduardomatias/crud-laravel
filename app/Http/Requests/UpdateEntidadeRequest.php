<?php

namespace App\Http\Requests;
use App\Helpers\Helper;

class UpdateEntidadeRequest extends BaseRequest
{
    
    /** @var string Related model */
    protected $modelRequest = 'App\Models\Entidade';

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
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param Request $request
     * @return void
     */
    public function beforeValidator($request)
    {
        $attr = $request->all();
        // set attr here
    }
    
}
