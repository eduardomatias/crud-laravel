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
     * @param string|Carbon $data data original
     * @param bool $time indica se exibe a hora
     * @param string $quem qual separador atual
     * @param string $por qual novo separador
     */
    public static function parseDate($data, bool $time = false, string $quem = '-', string $por = '/') : string
    {
        $dataFormatada = '';
        if ($data) {
            $dataHorario = explode(' ', $data);
            $dataSeparada = explode($quem, $dataHorario[0]);
            $dataFormatada = $dataSeparada[2] . $por . $dataSeparada[1] . $por . $dataSeparada[0] . ((!$time || !key_exists(1, $dataHorario)) ? '' : ' ' . substr($dataHorario[1], 0, 5));
        }
        return $dataFormatada;
    }
    public static function parseDateTime($data, string $quem = '-', string $por = '/') : string
    {
        return self::parseDate($data, true, $quem, $por);
    }
    
    /**
     * parseMoney
     *
     * @param string|float $numero
     * @param bool $exibeSeparador indica se exibe separador de decimal
     */
    public static function parseMoney($numero, bool $exibeSeparador = true) : string
    {
        $numeroFormatado = '';
        if ($numero) {
            if (!$exibeSeparador) {
                $numeroFormatado = str_replace(',', '.', str_replace('.', '', $numero));
            } else {
                if (is_string($numero)) {
                    $numeroFormatado = number_format((float) str_replace(',', '.', str_replace('.', '', $numero)), 2, ',', '.');
                } else {
                    $numeroFormatado = number_format($numero, 2, ',', '.');
                }
            }
        }
        return $numeroFormatado;
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
     * Obtem um array com as situacoes de pagamento
     * 
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @return Array
     */
    public static function getComboSituPagamento()
    {
        return [
            1 => 'Pagamento efetuado', 
            0 => 'Aguardando pagamento',
            '' => 'Aguardando pagamento'
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

    /**
     * Retorna texto convertido em UTF8
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param string|array|object $input
     * @return string|array|object
     */
    public static function utf8($input)
    {
        if (is_string($input)) {
            $input = mb_convert_encoding($input, "UTF-8", ['ASCII', 'UTF-8', 'ISO-8859-1']);
        } else if (is_array($input)) {
            foreach ($input as &$value) {
                utf8($value);
            }
            unset($value);
        } else if (is_object($input)) {
            $vars = array_keys(get_object_vars($input));
            foreach ($vars as $var) {
                utf8($input->$var);
            }
        }
        return $input;
    }

    /**
     * Retorna imagem do banco de dados
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param resource $resource
     * @return string
     */
    public static function imagemDB ($resource)
    {

        $my_bytea = stream_get_contents($resource);
        $my_string = pg_unescape_bytea($my_bytea);
        dd(htmlspecialchars($my_string));
        return htmlspecialchars($my_string);
    }

    /**
     * Saida de view para modal
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param view $view
     * @return string
     */
    public static function modal ($view)
    {
        return ['modal' => (string) $view];
    }

    /**
     * Descrição dos códigos de retorno da CIELO
     *
     * @author Eduardo Matias <eduardomatias@pbh.gov.br/eduardomatias.1989@gmail.com>
     * @param string $cod
     * @return string
     */
    public static function cieloRetornoAPI ($cod) 
    {
        $retorno = [
            '0' => 'Erro interno',
            '100' => 'RequestId é obrigatório',
            '101' => 'MerchantId é obrigatório',
            '102' => 'Tipo de pagamento é obrigatório',
            '103' => 'O tipo de pagamento só pode conter letras',
            '104' => 'A identidade do cliente é obrigatória',
            '105' => 'O nome do cliente é obrigatório',
            '106' => 'O ID da transação é obrigatório',
            '107' => 'OrderId é inválido ou não existe',
            '108' => 'O valor deve ser maior ou igual a zero',
            '109' => 'Moeda de pagamento é necessária',
            '110' => 'Moeda de Pagamento Inválido',
            '111' => 'Pagamento País é obrigatório',
            '112' => 'País de pagamento inválido',
            '113' => 'Código de pagamento inválido',
            '114' => 'O MerchantId fornecido não está no formato correto',
            '115' => 'O MerchantId fornecido não foi encontrado',
            '116' => 'O MerchantId fornecido está bloqueado',
            '117' => 'Titular do cartão de crédito é obrigatório',
            '118' => 'Número do cartão de crédito é obrigatório',
            '119' => 'Pelo menos um pagamento é necessário',
            '120' => 'Solicitar IP não permitido. Verifique sua lista branca de IP',
            '121' => 'O cliente é necessário',
            '122' => 'MerchantOrderId é obrigatório',
            '123' => 'As parcelas devem ser maiores ou iguais a um',
            '124' => 'Cartão de crédito é obrigatório',
            '125' => 'A data de vencimento do cartão de crédito é obrigatória',
            '126' => 'A data de expiração do cartão de crédito é inválida',
            '127' => 'Você deve fornecer o número do cartão de crédito',
            '128' => 'Comprimento do número do cartão excedido',
            '129' => 'Afiliação não encontrada',
            '130' => 'Não foi possível obter o cartão de crédito',
            '131' => 'MerchantKey é obrigatório',
            '132' => 'MerchantKey é inválido',
            '133' => 'O provedor não é compatível com este tipo de pagamento',
            '134' => 'Comprimento da impressão digital excedido',
            '135' => 'Comprimento de MerchantDefinedFieldValue excedido',
            '136' => 'O tamanho do ItemDataName foi excedido',
            '137' => 'Tamanho do ItemDataSKU excedido',
            '138' => 'O tamanho do PassengerDataName foi excedido',
            '139' => 'PassengerDataStatus length exceeded',
            '140' => 'PassengerDataEmail length exceded',
            '141' => 'Comprimento do PassengerDataPhone excedido',
            '142' => 'Tamanho de TravelDataRoute excedido',
            '143' => 'Duração de TravelDataJourneyType excedida',
            '144' => 'Comprimento de TravelLegDataDestination excedido',
            '145' => 'Comprimento de TravelLegDataOrigin excedido',
            '146' => 'Tamanho do SecurityCode excedido',
            '147' => 'Endereço Comprimento da rua excedido',
            '148' => 'Comprimento do número de endereço excedido',
            '149' => 'Endereço Comprimento do complemento excedido',
            '150' => 'Endereço ZipCode length exceeded',
            '151' => 'Endereço Comprimento da cidade excedido',
            '152' => 'Tamanho do estado do endereço excedido',
            '153' => 'Endereço País excedido',
            '154' => 'Endereço Comprimento do distrito excedido',
            '155' => 'Comprimento do nome do cliente excedido',
            '156' => 'Comprimento da identidade do cliente excedido',
            '157' => 'Comprimento da Identidade do Cliente excedido',
            '158' => 'Comprimento do email do cliente excedido',
            '159' => 'ExtraData Name length exceeded',
            '160' => 'Comprimento do valor extraData excedido',
            '161' => 'Boleto Comprimento das instruções excedido',
            '162' => 'Boleto Demostrative length exceeded',
            '163' => 'O URL de retorno é obrigatório',
            '166' => 'AuthorizeNow é obrigatório',
            '167' => 'Antifraude não configurado',
            '168' => 'Pagamento Recorrente não encontrado',
            '169' => 'Pagamento Recorrente não está ativo',
            '170' => 'Cartão Protegido não configurado',
            '171' => 'Dados de afiliação não enviados',
            '172' => 'Código de Credencial é obrigatório',
            '173' => 'O método de pagamento não está ativado',
            '174' => 'O número do cartão é obrigatório',
            '175' => 'EAN é obrigatório',
            '176' => 'Moeda de pagamento não é suportada',
            '177' => 'O número do cartão é inválido',
            '178' => 'EAN é inválido',
            '179' => 'O número máximo de parcelas permitidas para pagamento recorrente é 1',
            '180' => 'O cartão fornecido PaymentToken não foi encontrado',
            '181' => 'O MerchantIdJustClick não está configurado',
            '182' => 'Marca é necessária',
            '183' => 'Cliente inválido bithdate',
            '184' => 'O pedido não pode estar vazio',
            '185' => 'A bandeira não é suportada pelo provedor selecionado',
            '186' => 'O provedor selecionado não suporta as opções fornecidas (Capture, Authenticate, Recurrent ou Installments)',
            '187' => 'Coleção ExtraData contém um ou mais nomes duplicados'
        ];
        return !empty($retorno[$cod]) ? $retorno[$cod] : '';
    }
}



