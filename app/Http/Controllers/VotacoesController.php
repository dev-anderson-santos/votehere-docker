<?php

namespace App\Http\Controllers;

use App\Http\Services\VotacaoServices;
use App\Models\RoleModel;
use App\Models\RoleUserModel;
use App\Models\TipoModel;
use App\Models\TipoVotacaoModel;
use App\Models\User;
use App\Models\VotacaoModel;
use App\Models\VotosModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VotacoesController extends Controller
{
    public function __construct(private VotacaoServices $votacaoService)
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('votacao.index', ['votacoes' => VotacaoModel::paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('votacao.create', ['candidatos' => User::all(), 'tipos' => TipoModel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->votacaoService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('votacao.votacao', ['votacao' => $this->votacaoService->findById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('votacao.edit', [
            'votacao' => $this->votacaoService->findById($id),
            'candidatos' => User::all()->filter(function($item) {
                return !empty($item->roleUser) && $item->roleUser->role_id == RoleModel::CANDIDATO ? $item : null;
            }),
            'candidatos_da_votacao' => $this->votacaoService->findById($id)->candidatos()->get()->pluck('candidato_id')->toArray(),
            'tipos' => TipoModel::all()
        ]);
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
        return $this->votacaoService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->votacaoService->delete($id);
    }

    public function votar($id)
    {
        $votacao = $this->votacaoService->findById($id);
        if(!$votacao) {
            abort(404);
        }
        $data_hora_votacao = Carbon::parse($votacao->data_fim)->format('Y-m-d') . ' ' . Carbon::parse($votacao->hora_fim)->format('H:i');
            
        if($data_hora_votacao <= now()->format('Y-m-d H:i')) {
            return view('votacao.votacao-encerrada', ['votacao' => $votacao]);
        }

        return view('votacao.votar', ['votacao' => $this->votacaoService->findById($id)]);
    }

    public function categorias()
    {
        return view('votacao.tipo-votacao', [
            'tipo' => TipoModel::all()->isEmpty(), 
            'candidatos' => RoleUserModel::whereRoleId(RoleModel::CANDIDATO)->get()->isEmpty(), 
            'tipoVotacao' => TipoVotacaoModel::tipoVotacao()->paginate(5)
        ]);
    }

    public function getDisponibilidadeCanditados($votacao_id)
    {
        $candidatos = RoleUserModel::candidato()->get();
        $candidatosExistentes = [];
        foreach($candidatos as $candidato)
            $candidatosExistentes[$candidato->user_id] = VotosModel::candidato($candidato->user_id)->votacao($votacao_id)->first();

        $auxCandidatos = [];
        foreach ($candidatosExistentes as $key => $value) {
            if(empty($value))
                $auxCandidatos['ociosos'][$key] = User::find($key);
            else
            $auxCandidatos['nao_ociosos'][$key] = User::find($key);
        }

        return json_encode($auxCandidatos);
        
    }

    public function votacaoEncerrada($votacao_id)
    {
        $votacao = $this->votacaoService->findById($votacao_id);

        return view('votacao.votacao-encerrada', ['votacao' => $votacao]);
    }
}
