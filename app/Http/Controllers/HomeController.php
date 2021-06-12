<?php

namespace App\Http\Controllers;

use App\Mail\InformarEleitor;
use App\Models\RoleUserModel;
use App\Models\VotacaoModel;
use App\Models\VotosModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        return view('home', [
            'votacoes' => VotacaoModel::all(),
            'candidatos' => RoleUserModel::candidato()->get(),
            'eleitores' => RoleUserModel::eleitores()->get(),
            'votos' => VotosModel::votosComputados(),
        ]);
    }
}
