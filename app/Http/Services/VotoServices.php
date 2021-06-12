<?php

namespace App\Http\Services;

use App\Events\NewVote;
use App\Models\EleitorModel;
use App\Models\User;
use App\Models\VotacaoModel;
use App\Models\VotosModel;
use App\Notifications\NewVoteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotoServices {


    public function store(Request $request)
    {
        $dados = $request->all();

        try {
            DB::beginTransaction();
            
            $voto = VotosModel::whereId($dados['voto_id'])->first();
            
            $eleitor = EleitorModel::create([
                'user_id' => $dados['eleitor_id'],
                'voto_id' => $voto->id
            ]);
            
            $voto->update([
                'qtd_votos' => ($voto->qtd_votos + 1)
            ]);

            event(new NewVote($voto));

            DB::commit();

            $votacao = VotacaoModel::find($voto->votacao_id);
            
            if($votacao->avisar_encerramento == 0) {
                return response()->json(['status' => 'info', 'mensagem' => 'Deseja ser informado do resultado por e-mail?']);
            } else {
                return response()->json(['status' => 'success', 'mensagem' => 'Obrigado por votar!']);
            }
        } catch(\Exception $e) {

            DB::rollBack();
            return response()->json(['status' => 'error', 'mensagem' => env('APP_DEBUG') ? $e->getMessage() : 'Ocorreu um erro ao computar o voto.']);
        }
    }

    public function findById($votacao_id)
    {
        return response()->json([
            'votos' => VotosModel::votacao($votacao_id)->orderBy('qtd_votos', 'DESC')->get(),
            'maiorVoto' => VotosModel::votacao($votacao_id)->get()->max('qtd_votos')
        ]);
    }
}