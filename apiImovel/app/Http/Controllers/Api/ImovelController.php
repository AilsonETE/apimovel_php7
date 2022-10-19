<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Models\Imovel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImovelRequest;

class ImovelController extends Controller
{
    private $imovel;
    public function __construct(Imovel $imovel)
    {
        $this->imovel = $imovel;
    }
    public function index()
    {
        $imovel = $this->imovel->paginate('10');
        return response()->json($imovel, 200);
    }

    public function show($id)
    {
        try {
            $imovel = $this->imovel->findOrFail($id);
            return response()->json([
                'data' => [
                    $imovel
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['Erro' => $e->getMessage()], 401);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try {
            $imovel = $this->imovel->create($data);
            return response()->json([
                'data' => [
                    'msg' => 'Imovel cadastrado com sucesso'
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['Erro' => $e->getMessage()], 401);
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        try {
            $imovel = $this->imovel->findOrFail($id); #se tiver exceção ja testa
            $imovel->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Imovel Atualizado com sucesso'
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['Erro' => $e->getMessage()], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $imovel = $this->imovel->findOrFail($id); #se tiver exceção ja testa
            $imovel->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Imovel excluido com sucesso'
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['Erro' => $e->getMessage()], 401);
        }
    }
}
