<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class BaseModel
 * @package App\Models
 * @version August 14, 2018, 5:42 pm -03
 * 
 */
class BaseModel extends Model
{

    protected $user;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->user = \Illuminate\Support\Facades\Auth::user();
    }

    /**
     * The attributes that will be normalized.
     *
     * @var array
     */
    public static $attributeNormalize = [];

    /**
     * The attribute label.
     *
     * @var array
     */
    public static $attributeLabel = [];

    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules($id = 'NULL')
    {
        return [];
    }
    
    /**
     * Get all the attribute label or specified attribute by name.
     *
     * @param String $name attribute name
     * @return Array|String
     */
    public function getAttributeLabel($name = null)
    {
        return !$name ? static::$attributeLabel : (!empty(static::$attributeLabel[$name]) ? static::$attributeLabel[$name] : ucwords(str_replace('_', ' ', $name)));
    }

    /**
     * Get input required in validation rules
     *
     * @param String $name attribute name
     * @return Array|Bool
     */
    public function getAttributeRequired($name = null)
    {
        $rules = static::rules();
        $required = [];
        foreach ($rules as $attr => $r) {
            $required[$attr] = (strpos($r, 'required') !== false);
        }
        return !$name ? $required : (key_exists($name, $required) ? $required[$name] : false);
    }

}
