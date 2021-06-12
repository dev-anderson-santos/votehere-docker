<?php

namespace App\Http\Services;

use App\Models\EleitorModel;
use App\Models\RoleModel;
use App\Models\RoleUserModel;
use App\Models\TipoVotacaoModel;
use App\Models\User;
use App\Models\VotacaoModel;
use App\Models\VotosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotacaoServices {


    public function store(Request $request)
    {
        $dados = $request->all();
        if(!isset($dados['candidatos']) || count($dados['candidatos']) < 2) {
            return response()->json(['status' => 'warning', 'mensagem' => 'É necessário ter pelo menos 2 candidatos para criar uma votação.']);
        }
        
        try {
            DB::beginTransaction();
            
            $votacao = VotacaoModel::create([
                'data_inicio' => Carbon::parse($dados['data_inicio'])->format('Y-m-d'),
                'data_fim' => Carbon::parse($dados['data_fim'])->format('Y-m-d'),
                'hora_inicio' => Carbon::parse($dados['hora_inicio'])->format('H:i'),
                'hora_fim' => Carbon::parse($dados['hora_fim'])->format('H:i'),
                'status' => $dados['status'] ? 1 : 0,
                'avisar_encerramento' => $dados['avisar_encerramento'] ? 1 : 0,
            ]);
            
            foreach ($dados['candidatos'] as $value) {
                VotosModel::create([
                    'candidato_id' => $value,
                    'votacao_id' => $votacao->id,
                    'qtd_votos' => 0
                ]);
            }

            TipoVotacaoModel::create([
                'votacao_id' => $votacao->id,
                'tipo_id' => $dados['tipo']
            ]);

            DB::commit();
            return response()->json(['status' => 'success', 'mensagem' => 'Votação criada com sucesso']);
        } catch(\Exception $e) {

            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao atualizar a votação']);
        }
    }

    public function update(Request $request, $id)
    {
        $dados = $request->all();
        
        if(!isset($dados['candidatos']) || count($dados['candidatos']) < 2) {
            return response()->json(['status' => 'warning', 'mensagem' => 'É necessário ter pelo menos 2 candidatos para criar uma votação.']);
        }

        try {
            DB::beginTransaction();
            
            $votacao = VotacaoModel::find($id);

            $votacao->update([
                'data_inicio' => Carbon::parse($dados['data_inicio'])->format('Y-m-d'),
                'data_fim' => Carbon::parse($dados['data_fim'])->format('Y-m-d'),
                'hora_inicio' => Carbon::parse($dados['hora_inicio'])->format('H:i'),
                'hora_fim' => Carbon::parse($dados['hora_fim'])->format('H:i'),
                'status' => $dados['status'] ? 1 : 0,
                'avisar_encerramento' => $dados['avisar_encerramento'] ? 1 : 0,
            ]);
            
            $votos = VotosModel::where(['votacao_id' => $votacao->id])->get()->pluck('candidato_id')->toArray();
            $candidatos_retirados_da_votacao = array_diff($votos, $dados['candidatos']);

            // Remove os candidatos retirados da lista
            //TODO: colocar um aviso com o sweet alert informando que todos os votos no candidato removido serão perdidos
            // TODO: mas colocar o softdelete depois
            if(!empty($candidatos_retirados_da_votacao)) {
                $_votos = VotosModel::votacao($votacao->id)->whereIn('candidato_id', $candidatos_retirados_da_votacao)->get();

                foreach ($_votos as $voto) {
                    EleitorModel::whereVotoId($voto->id)->delete();
                    $voto->delete();
                }
            }

            // Cria os candidatos adicionados
            $candidatos_adicionados = array_diff($dados['candidatos'], $votos);
            if(!empty($candidatos_adicionados)) {
                foreach ($candidatos_adicionados as $candidato_id) {
                    VotosModel::create([
                        'candidato_id' => $candidato_id,
                        'votacao_id' => $votacao->id,
                        'qtd_votos' => 0
                    ]);
                }
            }

            TipoVotacaoModel::where(['votacao_id' => $votacao->id])->update([
                'tipo_id' => $dados['tipo']
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'mensagem' => 'Votação atualizada com sucesso']);
            
        } catch(\Exception $e) {

            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao atualizar a votação']);
        }
    }

    public function findById($votacao_id)
    {
        return VotacaoModel::whereId($votacao_id)->first();
    }

    public function delete($votacao_id)
    {
        try {
            $votacao = $this->findById($votacao_id);

            VotosModel::votacao($votacao->id)->whereIn('votacao_id', [$votacao->id])->delete();

            TipoVotacaoModel::where('votacao_id', $votacao->id)->delete();

            $votacao->delete();
            
            DB::commit();

            return response()->json(['status' => 'success', 'mensagem' => 'Votação removida com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao remover a votação']);
        }        
    }
}