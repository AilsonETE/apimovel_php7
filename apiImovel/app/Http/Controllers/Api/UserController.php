<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Api\ApiMessages;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
   
    public function __construct(User $user)
    {
        $this->user = $user;

    }


    public function index()
    {
        $user = $this->user->paginate('10');

        return response()->json($user, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('É nessario informar uma senha para o usuario');
            return response()->json($message->getMessage(), 401);
        }
        Validator::make($data, [
            'celular' => 'required',
            'telefone' => 'required'
        ]);
        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);
            $user->perfil()->create(
                [
                    'telefone' => $data['telefone'],
                    'celular' => $data['celular']
                ]
            );
            return response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
            try {
                //busca o usuário ja com seu perfil
                 $user = $this->user->with('perfil')->findOrFail($id);
                return response()->json([
                    'data' => [
                        $user
                    ]
                ], 200);
            } catch (\Exception $e) {
                return response()->json(['Erro' => $e->getMessage()], 401);
            }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($request->has('password')&& $request->get('password')){

           $data['password'] = bcrypt($data['password']);
        } else{
            unset($data['password']);
        }

        Validator::make($data,[
            'perfil.celular' => 'required',
            'perfil.telefone' => 'required'
        ])->validate();


        try{

           $perfil = $data['perfil'];
           $perfil['redes_sociais'] = serialize($perfil['redes_sociais']);

           $user = $this->user->findOrFail($id); #se tiver exceção ja testa
           $user->update($data);
           dd($data);
           // Atualiza o perfildo usuario recebendo o array

           $user->perfil()->update($perfil);

           return response()->json([
               'data' => [
                   'msg' => 'Usuário Atualizado com sucesso'
               ]
           ], 200);

        }catch(\Exception $e){
           return response()->json(['Erro' => $e->getMessage()], 401);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = $this->imovel->findOrFail($id); #se tiver exceção ja testa
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuario excluido com sucesso'
                ]
            ], 200);

         }catch(\Exception $e){
            return response()->json(['Erro' => $e->getMessage()], 401);

         }

    }
}
