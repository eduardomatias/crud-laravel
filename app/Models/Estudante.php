<?php

namespace App\Models;

/**
 * Class Entidade
 * @package App\Models
 */
class Entidade extends BaseModel
{

    public $table = 'entidade';
    protected $primaryKey = 'id_entidade';
    public $incrementing = false;

    const CREATED_AT = 'dat_cadastro';
    const UPDATED_AT = 'dat_alteracao';

    protected $dates = [];
    
    public $fillable = [
        'nome_entidade',
        'user_cadastro',
        'user_alteracao'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entidade' => 'integer',
        'nome_entidade' => 'string',
        'user_cadastro' => 'string',
        'user_alteracao' => 'string'
    ];

    /**
     * The attribute label.
     *
     * @var array
     */
    public static $attributeLabel = [
        'id_entidade' => 'Entidade',
        'nome_entidade' => 'Nome da Entidade',
        'user_cadastro' => 'Usuário de cadastro',
        'dat_cadastro' => 'Data de cadastro',
        'user_alteracao' => 'Usuário de alteração',
        'dat_alteracao' => 'Data de alteração'
    ];

    /**
     * The attributes that will be normalized.
     *
     * @var array
     */
    public static $attributeNormalize = [
        'nome_entidade'
    ];

    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules($id = 'NULL')
    {
        return [
            'nome_entidade' => 'required|max:150'
        ];
    }

}
