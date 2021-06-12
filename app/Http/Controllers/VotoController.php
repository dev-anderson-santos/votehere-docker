<?php

namespace App\Http\Controllers;

use App\Http\Services\VotoServices;
use App\Models\VotosModel;
use Illuminate\Http\Request;

class VotoController extends Controller
{
    private $votoService;

    public function __construct(VotoServices $votoService)
    {
        $this->votoService = $votoService;
    }

    public function votar(Request $request)
    {
        return $this->votoService->store($request);
    }

    public function obrigado()
    {
        return view('voto.obrigado');
    }

    public function show($id)
    {
        return $this->votoService->findById($id);
    }
}
