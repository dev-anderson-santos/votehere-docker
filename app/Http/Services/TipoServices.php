<?php

namespace App\Http\Services;

use App\Models\TipoModel;
use App\Models\TipoVotacaoModel;
use App\Models\VotacaoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoServices {

    public function store(Request $request)
    {
        $dados = $request->all();
        // return $dados;
        try {
            DB::beginTransaction();
            
            TipoModel::create(['nome' => $dados['nome']]);

            DB::commit();
            return response()->json(['status' => 'success', 'mensagem' => 'Cadastrado realizado com sucesso.']);
        } catch(\Exception $e) {

            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Cadastrado realizado com sucesso.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            TipoModel::find($id)->update(['nome' => $request->nome]);

            DB::commit();            
            session()->put('success', 'Categoria atualizada com sucesso.');
            return response()->json(['status' => 'success']);
        } catch(\Exception $e) {

            DB::rollBack();
            
            session()->put('error', env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao atualizar.');
            return response()->json(['status' => 'error']);
        }
    }

    public function delete($tipo_id)
    {
        try {
            DB::beginTransaction();
            
            $tipo = TipoModel::whereId($tipo_id)->first();

            $tipoVotacao = TipoVotacaoModel::whereTipoId($tipo->id)->first();
            
            if($tipoVotacao) {
                
                $votacao = VotacaoModel::whereId($tipoVotacao->votacao_id)->first();
                
                if($votacao->status == 1) {
                    return redirect()->route('tipo.index')->with('warning', 'Esta categoria está em uso e não pode ser excluída.');
                }
                
                $tipoVotacao->delete();
            }
            
            $tipo->delete();

            DB::commit();
            return redirect()->route('tipo.index')->with('success', 'Categoria removida com sucesso.');
        } catch(\Exception $e) {

            DB::rollBack();
            return redirect()->route('tipo.index')->with('error', env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao remover.');
        }
    }
}