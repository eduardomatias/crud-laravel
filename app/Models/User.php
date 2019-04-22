<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version April 22, 2019, 4:24 pm -03
 *
 * @property string name
 * @property string email
 * @property string password
 * @property boolean admin
 * @property string remember_token
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class User extends BaseModel
{
    public $table = 'users';

    protected $primaryKey = 'id';

    public $incrementing = false;

    /**
     * IMPORTANT: Quando a exclusao for logica
     * descomentar as duas proximas linhas e edite a const: DELETED_AT
     */
    // use SoftDeletes;
    // protected $softDelete = false;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    // const DELETED_AT = 'deleted_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'admin' => 'boolean',
        'remember_token' => 'string'
    ];

    /**
     * The attribute label.
     *
     * @var array
     */
    public static $attributeLabel = [        
        'id' => 'id',
        'name' => 'Nome',
        'email' => 'E-mail',
        'password' => 'Senha',
        'admin' => 'Administrador?',
        'remember_token' => 'Relembrar?',
        'created_at' => 'Criado',
        'updated_at' => 'Alterado'
    ];
    
    /**
     * The attributes that will be normalized.
     *
     * @var array
     */
    public static $attributeNormalize = [
        'name'
    ];
    
    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules($id = 'NULL')
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,' . $id . ',id',
            'password' => 'required|max:255',
            'admin' => 'required',
            'remember_token' => 'max:100',
            'created_at' => '',
            'updated_at' => ''
        ];
    }

    
}
