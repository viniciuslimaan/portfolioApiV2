<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortfolioRequest;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
            $data = DB::table('portfolios')
                ->orderByRaw("FIELD(type, 'design', 'prototype', 'web', 'mobile')")
                ->orderBy('name')
                ->get();

            $newData = $data->map(function ($item) {
                $item = (array) $item;
                $item['image_url'] = Storage::url($item['image']);
                return $item;
            });

            $return = ['data' => $newData];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao listar todos os portfólios!', 'error' => $e->getMessage()]];
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
            $return = ['data' => ['msg' => 'Houve um erro ao cadastrar um novo portfólio!', 'error' => $e->getMessage()]];
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
            $data = Portfolio::findOrFail($id);

            $data['image_url'] = Storage::url($data['image']);
            
            $return = ['data' => $data];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao mostrar o portfólio!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }

    /**
     * Update a specific portfolio
     *
     * @param PortfolioRequest $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(PortfolioRequest $request, int $id): JsonResponse
    {
        try {
            $newPortfolioData = $request->all();
            $portfolioData = Portfolio::findOrFail($id);

            if (isset($newPortfolioData['image'])) {
                Storage::delete($portfolioData->image);
                $newPortfolioData['image'] = $newPortfolioData['image']->store('images', 'public');
            }

            $portfolioData->update($newPortfolioData);

            $return = ['data' => ['msg' => 'Portfólio editado com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao editar o portfólio!', 'error' => $e->getMessage()]];
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
            $portfolioData = Portfolio::findOrFail($id);

            if (Storage::exists($portfolioData->image)) {
                Storage::delete($portfolioData->image);
            }

            $portfolioData->delete();

            $return = ['data' => ['msg' => 'Portfólio excluído com sucesso!']];
            $code = 200;
        } catch (\Exception $e) {
            $return = ['data' => ['msg' => 'Houve um erro ao excluir o portfólio!', 'error' => $e->getMessage()]];
            $code = 400;
        } finally {
            return response()->json($return, $code);
        }
    }
}
