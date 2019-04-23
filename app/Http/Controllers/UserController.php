<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
        parent::__construct();
    }

    /**
     * Display a listing of the Usuário.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();
        return view('users.index', [
            'users' => $users, 
            'search' => $request->input('search')]);
    }

    /**
     * Show the form for creating a new Usuário.
     *
     * @return Response
     */
    public function create()
    {
        $user = $this->userRepository->new();
        return view('users.create')->with('user', $user);
    }

    /**
     * Store a newly created Usuário in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->userRepository->create($input);

        Flash::success('Usuário salvo com sucesso.');

        return redirect(route('users.index'));
    }

    /**
     * Display the specified Usuário.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified Usuário.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified Usuário in storage.
     *
     * @param  int              $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('users.index'));
        }

        $user = $this->userRepository->update($request->all(), $id);

        Flash::success('Usuário alterado com sucesso.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified Usuário from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuário não encontrado');
            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('Usuário excluído com sucesso.');

        return redirect(route('users.index'));
    }

    /**
     * Show the form for editing the password Usuário.
     *
     * @return Response
     */
    public function editPassword()
    {
        return view('users.edit_password');
    }

    /**
     * Update the specified Usuário in storage.
     *
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function updatePassword(UpdateUserRequest $request)
    {
        $user = $this->userRepository->findWithoutFail($this->currentUsuario['id']);

        if ($request->repeat_password != $request->new_password) {
            Flash::error('As senhas não conferem.');
            return redirect(route('users.password'));
        }

        $user = $this->userRepository->update(['password' => Hash::make($request->new_password)], $this->currentUsuario['id']);

        Flash::success('Senha alterada com sucesso.');

        return redirect()->back();
    }
}
