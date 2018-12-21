<?php

namespace InfyOm\Generator\Common;

use Exception;
use Illuminate\Container\Container as Application;

abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository
{
    
    public function findWithoutFail($id, $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (Exception $e) {
            return;
        }
    }
    
    /**
     * Verfifica se o registro existe a partir do ID
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param Int $id model->find($id)
     * @param String $msg 'Registro não encontrado.'
     * @return Model:find|Exception
     */
    public function exists($id, $msg = 'Registro não encontrado.')
    {
        if (!($find = $this->findWithoutFail($id))) {
            throw new \Exception($msg);
        } else {
            return $find;
        }
    }
    
    /**
     * Obtem dados organizados em um array (chave|valor)
     * uma alternativa para obter itens de um combo, select, autocomplete ou lista
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param String $columns_key
     * @param String $columns_value
     * @param String $where 
     * @param Bool $fistEmpty adiciona a opção '' => 'Selecione'
     * @param String $columns_order
     * @return Array
     */
    public function getCombo($columns_key, $columns_value, $where = null, $fistEmpty = true, $columns_order = null)
    {
        if ($where) {
            $this->applyConditions($where);
        }

        // verifica campo concatenado
        $arrayColValue = explode('||', str_replace('"', "'", $columns_value));
        if (count($arrayColValue) > 1) {
            $colSelect = [];
            foreach ($arrayColValue as $v) {
                $colSelect[] = $v;
            }
            $columns_value_select = \Illuminate\Support\Facades\DB::raw("CONCAT(" . implode(',', $colSelect) . ") AS text_concat");
            $columns_value = 'text_concat';
        } else {
            $columns_value_select = $columns_value = $columns_value;
        }

        // obtem dados do combo
        $data = $this->orderBy(($columns_order ?: $columns_value))->get([$columns_key, $columns_value_select]);

        // format combo
        $combo = array();
        if ($fistEmpty) {
            $combo[''] = "Selecione";
        }
        foreach ($data as $d) {
            $combo[$d->$columns_key] = $d->$columns_value;
        }

        return $combo;
    }

    public function create(array $attributes)
    {
        // Have to skip presenter to get a model not some data
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::create($attributes);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    public function update(array $attributes, $id)
    {
        // Have to skip presenter to get a model not some dataz
        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        $model = parent::update($attributes, $id);
        $this->skipPresenter($temporarySkipPresenter);

        $model = $this->updateRelations($model, $attributes);
        $model->save();

        return $this->parserResult($model);
    }

    public function updateRelations($model, $attributes)
    {
        foreach ($attributes as $key => $val) {
            if (isset($model) &&
                method_exists($model, $key) &&
                is_a(@$model->$key(), 'Illuminate\Database\Eloquent\Relations\Relation')
            ) {
                $methodClass = get_class($model->$key($key));
                switch ($methodClass) {
                    case 'Illuminate\Database\Eloquent\Relations\BelongsToMany':
                        $new_values = array_get($attributes, $key, []);
                        if (array_search('', $new_values) !== false) {
                            unset($new_values[array_search('', $new_values)]);
                        }
                        $model->$key()->sync(array_values($new_values));
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\BelongsTo':
                        $model_key = $model->$key()->getQualifiedForeignKey();
                        $new_value = array_get($attributes, $key, null);
                        $new_value = $new_value == '' ? null : $new_value;
                        $model->$model_key = $new_value;
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasOne':
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasOneOrMany':
                        break;
                    case 'Illuminate\Database\Eloquent\Relations\HasMany':
                        $new_values = array_get($attributes, $key, []);
                        if (array_search('', $new_values) !== false) {
                            unset($new_values[array_search('', $new_values)]);
                        }

                        list($temp, $model_key) = explode('.', $model->$key($key)->getQualifiedForeignKeyName());

                        foreach ($model->$key as $rel) {
                            if (!in_array($rel->id, $new_values)) {
                                $rel->$model_key = null;
                                $rel->save();
                            }
                            unset($new_values[array_search($rel->id, $new_values)]);
                        }

                        if (count($new_values) > 0) {
                            $related = get_class($model->$key()->getRelated());
                            foreach ($new_values as $val) {
                                $rel = $related::find($val);
                                $rel->$model_key = $model->id;
                                $rel->save();
                            }
                        }
                        break;
                }
            }
        }

        return $model;
    }
}
