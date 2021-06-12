<?php

namespace App\Http\Services;

use App\Models\RoleModel;
use App\Models\RoleUserModel;
use App\Models\User;
use App\Models\VotosModel;
use Facade\Ignition\QueryRecorder\QueryRecorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserServices {


    public function store(Request $request)
    {
        $dados = $request->all();
        
        try {
            DB::beginTransaction();
            
            $dados['password'] = \Illuminate\Support\Facades\Hash::make('password');

            if($request->hasFile('avatar')) {

                $user = User::create($dados);

                $imagem = $request->file('avatar');
                $path = $imagem->store('public/img/users/user-' . $user->id);

                $path = explode('public/', $path);

                User::whereId($user->id)->update([
                    'avatar' => last($path)
                ]);
            } else {
                return redirect()->route('usuario.index')->with('É necessário enviar uma imagem do candidato.');
                // return response()->json(['status' => 'warning', 'mensagem' => 'É necessário enviar uma imagem do candidato.']);
            }
            
            RoleUserModel::create([
                'role_id' => RoleModel::CANDIDATO,
                'user_id' => $user->id,
                'status' => 1
            ]);

            DB::commit();
            return redirect()->route('usuario.index')->with('success', 'Cadastrado com sucesso.');
            // return response()->json(['status' => 'success', 'mensagem' => 'Cadastrado com sucesso.']);
        } catch(\Exception $e) {

            DB::rollBack();
            return redirect()->route('usuario.create')->with('error', env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao cadastrar.');
            // return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao cadastrar.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->update($request->except('_token'));

            if($request->hasFile('avatar')) {
                $imagem = $request->file('avatar');
                $path = $imagem->store('public/img/users/user-' . $user->id);

                $path = explode('public/', $path);

                User::whereId($user->id)->update([
                    'avatar' => last($path)
                ]);
            }

            DB::commit();
            return redirect()->route('usuario.index')->with('success', 'Atualizado com sucesso.');
        } catch(\Exception $e) {

            DB::rollBack();
            return redirect()->route('usuario.edit', $id)->with('error', env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao atualizar.');
        }
    }

    public function findById($candidato_id)
    {
        $user = User::findOrFail($candidato_id);
        return $user ?? abort(404);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            if(!VotosModel::candidato($id)->first()) {
                RoleUserModel::whereUserId($id)->delete();
                User::destroy($id);
            } else {
                return response()->json(['status' => 'warning', 'mensagem' => 'Este candidato está participando de uma votação e não pode ser removido.']);    
            }

            DB::commit();
            return response()->json(['status' => 'success', 'mensagem' => 'Candidato removido com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao remover o candidato.']);
        }
    }

    public function killThemAll()
    {
        try {
            DB::beginTransaction();
            $candidatos = RoleUserModel::candidato()->get();
            if($candidatos->count() > 0) {
                foreach ($candidatos as $candidato) {

                    $candidato_particiapente = VotosModel::candidato($candidato->user_id)->first();
                    if($candidato_particiapente) {

                        $user = User::whereId($candidato_particiapente->candidato_id)->first();
                        return response()->json(['status' => 'info', 'mensagem' => "O candidato $user->name, está participando de uma votação e não pode ser removido."]);
                    } else {
                        RoleUserModel::whereId($candidato->id)->delete();
                        User::whereId($candidato->user_id)->delete();
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'mensagem' => 'Candidatos removidos com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao remover o candidato.']);
        }
    }
}