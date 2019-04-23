<?php
namespace App\Http\Requests;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    
    public function initialize(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::initialize($query, $request, $attributes, $cookies, $files, $server, $content);
        // para create ou update set a usuário da alteracao
        $AuthUser = Auth::user();
        $this->request->add([
            'user_alteracao' => ($AuthUser) ? $AuthUser->login : ''
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Obtem o ID quando controller/ID/edit
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @return String ID or NULL
     */
    public function getIdRules()
    {
        $getPathInfo = explode('/', $this->getPathInfo());
        return (!empty($getPathInfo[2])) ? $getPathInfo[2] : 'NULL';
    }
 
    /**
     * Padroniza a entrada dos atributos definidos no modelo ($attributeNormalize).
     * Verifica se o beforeValidator foi implementado e executa se o mesmo existir
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     */    
    protected $modelRequest = '';
    public function getValidatorInstance()
    {
        // padroniza entradas antes de qualquer coisa
        if ($this->modelRequest) {
            $this->padronizaEntrada($this->modelRequest::$attributeNormalize);
        }
        
        // permite maninular os dados da request antes de validar
        if (method_exists($this, 'beforeValidator')) {
            $this->beforeValidator($this->request);
        }
        
        return parent::getValidatorInstance();
    }
    
    /**
     * Normaliza os atributos da requisição
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param Array $attr
     */
    private function padronizaEntrada($attr = [])
    {
        if ($attr) {
            $attr = is_array($attr) ? $attr : (array) $attr;
            foreach ($attr as $value) {
                $getValue = $this->request->get($value);
                if (!empty($getValue)) {
                    $this->request->set($value, Helper::entradapadronizada($getValue));
                }
            }
        }
    }
    
    /**
     * Remove obrigatoriedade das regras
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param Array $rules regras da request
     * @return Array
     */
    protected function rulesRequiredOff($rules)
    {
        return array_map(function($value) {
            return str_replace('required', '', str_replace('required|', '', $value));
        }, $rules);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}