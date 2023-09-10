<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Authenticate route
     */
    public function __construct()
    {
        $this->middleware('auth.routes:api');
    }

    /**
     * Show all users
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = User::all();

            $return = ['data' => $data];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao listar todos os usuários!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Add a new user
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        try {
            $userData = $request->all();

            $userData['password'] = bcrypt($userData['password']);

            User::create($userData);

            $return = ['data' => ['msg' => 'Usuário cadastrado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao cadastrar um novo usuário!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Show a specific user
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = User::findOrFail($id);

            $return = ['data' => $data];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao mostrar o usuário!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Update a specific user
     *
     * @param UserRequest $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(UserRequest $request, int $id): JsonResponse
    {
        try {
            $userData = $request->all();
            $user = User::findOrFail($id);

            if ($userData['password']) {
                $userData['password'] = bcrypt($userData['password']);
            } else {
                $userData['password'] = $user->password;
            }

            $user->update($userData);

            $return = ['data' => ['msg' => 'Usuário editado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao editar o usuário!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Delete a specific user
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            User::findOrFail($id)->delete();

            $return = ['data' => ['msg' => 'Usuário excluído com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao excluir o usuário!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }
}
