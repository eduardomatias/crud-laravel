<?php
namespace App\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Helper
{

    /**
     * parseDate
     *
     * @param string $data data original
     * @param bool $time indica se exibe a hora
     * @param string $quem qual separador atual
     * @param string $por qual novo separador
     */
    public static function parseDate(string $data, bool $time = false, string $quem = '-', string $por = '/') : string
    {
        $dataFormatada = '';
        if ($data) {
            $dataHorario = explode(' ', $data);
            $dataSeparada = explode($quem, $dataHorario[0]);
            $dataFormatada = $dataSeparada[2] . $por . $dataSeparada[1] . $por . $dataSeparada[0] . ((!$time || !key_exists(1, $dataHorario)) ? '' : ' ' . $dataHorario[1]);
        }
        return $dataFormatada;
    }
    public static function parseDateTime(string $data, string $quem = '-', string $por = '/') : string
    {
        return self::parseDate($data, true, $quem, $por);
    }
    
    /**
     * formataNomeBusca
     *
     * remove caracteres especiais da string
     *
     * @param string $data data original
     */
    public static function formataNomeBusca($str) :string
    {
        $retorno = "";
        if (!empty($str)) {       
          $retorno = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($str)));
          $retorno = preg_replace('/[^a-z0-9]/i', ' ', $retorno);
        } 
        return trim($retorno);
      }

    /**
     * método que retorna query como lista ordenada e paginada
     * @param String $sort_by
     * @param int $paginate
     * @param int $paginateOnServer
     * @return Lista paginada e ordenada 
     */
    public static function getAsListaOrdenadaPaginada($queryBuilder, $sort_by=null, $paginate = 10)
    {
        $result = $queryBuilder->when($sort_by, function ($q) use ($sort_by) {
            list($cl, $direc) = explode(" ", $sort_by);   
            return $q->orderBy($cl, $direc);
        });
        if($paginate) {
            $items = collect($result->get());
            $result = new LengthAwarePaginator($items, $items->count(), $paginate, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);
        }
        return $result;
    }

    /**
     * método que pagina colecao
     * @param int $paginate
     * @return Lista paginada e ordenada 
     */
    public static function paginaLista($lista, $paginate = 10)
    {
        return new LengthAwarePaginator($lista, $lista->count(), $paginate, Paginator::resolveCurrentPage(), ['path' => Paginator::resolveCurrentPath()]);
    }

    /**
     * somenteNumeros
     *
     * remove caracteres nao numericos
     *
     * @param string
     */
    public static function somenteNumeros($str) :string
    {
        return preg_replace('/[^0-9]/i', '', $str);
    }    
    
    /**
     * semNumeros
     *
     * remove caracteres numericos
     *
     * @param string
     */
    public static function semNumeros($str) :string
    {
        return preg_replace('/[0-9]/i', '', $str);
    }
    
    /**
     * parseSitu
     *
     * retorna o nome da situação a partir do codigo
     *
     * @param string
     */
    public static function parseSitu($cod) :string
    {
        switch ($cod) {
            case 'A':
            case 1:
                $str = 'Ativo';
                break;
            case 'I':
            case 0:
                $str = 'Inativo';
                break;
            default:
                $str = '';
                break;
        }
        return $str;
    }

    /**
     * Verifica se o CPF é válido
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param String $cpf 
     * @return Bool false|String CPF
     */
    public static function validateCPF(string $cpf)
    {        
        if (empty($cpf)) {
            return false;
        }

        // apenas numeros
        $cpf = self::somenteNumeros($cpf);
        
        // tamanho do CPF
        if (strlen($cpf) != 11) {
            return false;
        }

        // sequências invalidas
	    if ($cpf == '00000000000' || 
            $cpf == '11111111111' || 
            $cpf == '22222222222' || 
            $cpf == '33333333333' || 
            $cpf == '44444444444' || 
            $cpf == '55555555555' || 
            $cpf == '66666666666' || 
            $cpf == '77777777777' || 
            $cpf == '88888888888' || 
            $cpf == '99999999999') {
		    return false;
        }
        
        // Calcula os digitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        
        return $cpf;
    }

    /**
     * Obtem um array com as opções de sexo
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @return Array
     */
    public static function getComboSexo()
    {
        return [
            ''  => 'Selecione', 
            'F' => 'Feminino', 
            'M' => 'Masculino'
        ];
    }

    /**
     * Obtem um array com as situacoes
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @return Array
     */
    public static function getComboSitu()
    {
        return [
            ''  => 'Selecione', 
            1 => 'Ativo', 
            0 => 'Inativo'
        ];
    }

    /**
     * Verifica se a instance é de um model
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @return Bool
     */
    public static function isModel($instance)
    {
        return (!is_subclass_of($instance, 'Illuminate\Database\Eloquent\Model'));
    }

    /**
     * Verifica se a instance é de uma Collection
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @return Bool
     */
    public static function isCollection($instance)
    {
        return (!is_subclass_of($instance, 'Illuminate\Database\Eloquent\Collection'));
    }

    /**
     * Retorna um array com o campo solicitado de uma Collection
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param Instance $collection collection
     * @param String $field attribute
     * @return Array
     */
    public static function toArrayField($collection, $field)
	{
		$a = [];
		if (Helper::isCollection($collection)) {
			foreach ($collection as $c) {
				if (!empty($c->$field)) {
					$a[] = $c->$field;
				}
			}
		}
		return $a;
	}
	
    /**
     * Retorna uma string padronizada
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param string $str
     * @return string
     */

    public static function entradapadronizada($str) :string
	{
		if (is_string($str)) {

			$auxtexto=str_replace('  ',' ',$str);
			while(!(strpos($auxtexto,'  ') === false)) {
				$auxtexto=str_replace('  ',' ',$auxtexto);
			}

			$padroes=array('Â','Á','À','Ã','â','á','à','ã','Ê','É','È','Ê','ê','é','è','Î','Í','Ì','î','í','ì','Ô','Ó','Ò','Õ','ô','ó','ò','õ','Û','Ú','Ù','û','ú','ù','ç','Ç',"'",'"');
			$valores=array('A','A','A','A','a','a','a','a','E','E','E','E','e','e','e','I','I','I','i','i','i','O','O','O','O','o','o','o','o','U','U','U','u','u','u','c','C','','');
			$auxtexto=str_replace($padroes,$valores,$auxtexto);
			$auxtexto=strtoupper($auxtexto);
			return $auxtexto;
		
		} else {
			return($str);
		}
	}
}



