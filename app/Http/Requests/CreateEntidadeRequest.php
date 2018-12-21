<?php

namespace App\Http\Requests;

class CreateEntidadeRequest extends BaseRequest
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
        return $this->modelRequest::rules();
    }
    
}
