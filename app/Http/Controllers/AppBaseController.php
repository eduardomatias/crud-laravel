<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Illuminate\Support\Facades\Auth;
use Response;
use Flash;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
	
    public $currentRoute;
    public $usuarioRestrito;
    public $currentUsuario;
    public $currentPerfil;
    public $currentMenu;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
			// route atual
            $this->currentRoute = $request->route()->getName();
            
            // verifica permissão apenas quando logado
            if (Auth::check()) {
                $this->usuarioRestrito  = true;
                $this->currentUsuario   = Auth::user()->toArray();
                $this->currentPerfil    = $request->session()->get('currentPerfil');
                $this->currentMenu      = $request->session()->get('currentMenu');
                
            } else {
                $this->usuarioRestrito  = false;
                $this->currentUsuario   = false;
                $this->currentPerfil    = $request->session()->get('currentPerfil');
                $this->currentMenu      = $request->session()->get('currentMenu');
				
            }
			
			// disponibiliza dados na view
			\Illuminate\Support\Facades\View::share([
				'currentRoute'      => $this->currentRoute,
				'usuarioRestrito'   => $this->usuarioRestrito,
				'currentUsuario'    => $this->currentUsuario,
				'currentPerfil'     => $this->currentPerfil,
				'currentMenu'       => $this->currentMenu
			]);
            
            return $next($request);
        });
    }
	
    private function acessoPermitido($request)
    {
        return true;
    }
    
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
