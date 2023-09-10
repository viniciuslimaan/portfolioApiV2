<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Authenticate route
     */
    public function __construct()
    {
        $this->middleware('auth.routes:api', ['except' => ['index', 'show']]);
    }

    /**
     * Show all portfolios
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $return = Portfolio::all();
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao listar todos os portfólios!', 'error' => $e]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Add a new portfolio
     *
     * @param PortfolioRequest $request
     * @return JsonResponse
     */
    public function store(PortfolioRequest $request): JsonResponse
    {
        try {
            $portfolioData = $request->all();

            $portfolioData['image'] = $portfolioData['image']->store('images', 'public');

            Portfolio::create($portfolioData);

            $return = ['data' => ['msg' => 'Portfólio cadastrado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao cadastrar um novo portfólio!', 'error' => $e]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Show a specific portfolio
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $return = Portfolio::find($id);
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao mostrar o portfólio!', 'error' => $e]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Update a specific portfolio
     *
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $portfolioData = Portfolio::find($id);

            $portfolioData->update($request->all());

            $return = ['data' => ['msg' => 'Portfólio editado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao editar o portfólio!', 'error' => $e]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Delete a specific portfolio
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $portfolioData = Portfolio::find($id);

            if (Storage::exists($portfolioData->image)) {
                Storage::delete($portfolioData->image);
            }

            $portfolioData->delete();

            $return = ['data' => ['msg' => 'Portfólio excluído com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao excluir o portfólio!', 'error' => $e]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }
}
