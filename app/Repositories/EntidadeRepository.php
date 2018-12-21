<?php

namespace App\Repositories;

use App\Models\Entidade;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class EntidadeRepository
 * @package App\Repositories
 *
 * @method Entidade findWithoutFail($id, $columns = ['*'])
 * @method Entidade find($id, $columns = ['*'])
 * @method Entidade first($columns = ['*'])
*/
class EntidadeRepository extends BaseRepository
{
    
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nome_entidade'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Entidade::class;
    }
    
}

