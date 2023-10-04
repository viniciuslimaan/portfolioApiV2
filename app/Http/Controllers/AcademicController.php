<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicRequest;
use App\Models\Academic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AcademicController extends Controller
{
    /**
     * Authenticate route
     */
    public function __construct()
    {
        $this->middleware('auth.routes:api', ['except' => ['index', 'show']]);
    }

    /**
     * Show all academics
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = DB::table('academics')
                ->orderByRaw("FIELD(semester, 'one', 'two', 'three', 'four', 'five', 'six')")
                ->get();

            $newData = $data->map(function ($item) {
                $item = (array) $item;
                $item['image_url'] = Storage::url($item['image']);
                return $item;
            });

            $return = ['data' => $newData];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao listar todos os projetos acadêmicos!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Add a new academic
     *
     * @param AcademicRequest $request
     * @return JsonResponse
     */
    public function store(AcademicRequest $request): JsonResponse
    {

        try {
            $academicData = $request->all();

            $academicData['image'] = $academicData['image']->store('images', 'public');

            Academic::create($academicData);

            $return = ['data' => ['msg' => 'Projeto acadêmico cadastrado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao cadastrar um novo projeto acadêmico!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Show a specific academic
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = Academic::findOrFail($id);

            $data['image_url'] = Storage::url($data['image']);

            $return = ['data' => $data];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao mostrar o projeto acadêmico!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Update a specific academic
     *
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $academicData = Academic::findOrFail($id);

            $academicData->update($request->all());

            $return = ['data' => ['msg' => 'Projeto acadêmico editado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao editar o projeto acadêmico!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Delete a specific academic
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $academicData = Academic::findOrFail($id);

            if (Storage::exists($academicData->image)) {
                Storage::delete($academicData->image);
            }

            $academicData->delete();

            $return = ['data' => ['msg' => 'Projeto acadêmico excluído com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao excluir o projeto acadêmico!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }
}
