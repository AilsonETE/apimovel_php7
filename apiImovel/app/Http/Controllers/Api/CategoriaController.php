<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    private $categoria;
public function __construct(Categoria $categoria)
{
$this->categoria = $categoria;
 }

 public function index()
 {
     $categoria = $this->categoria->all();
     return response()->json($categoria, 200);
 }

 public function show($id)
 {
     try {
        $categoria = $this->findOrFail($id);
         return response()->json([
             'data' => [
                $categoria
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
         $categoria = $this->categoria->create($data);
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
