<?php

namespace App\Console\Commands;

use App\Events\VotacaoEncerrada;
use App\Mail\InformarEleitor;
use App\Models\VotacaoModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AvisarFimVotacaoEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:aviso';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que avisa o fim da votação para o eleitor';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $votacoes = VotacaoModel::all();

        foreach ($votacoes as $value) {
            $data_hora_votacao = Carbon::parse($value->data_fim)->format('Y-m-d') . ' ' . Carbon::parse($value->hora_fim)->format('H:i');

            if($data_hora_votacao == now()->format('Y-m-d H:i')) {
                VotacaoModel::find($value->id)->update(['status' => 2]);
                event(new VotacaoEncerrada($value));
                Mail::to('andermarvel@gmail.com')->send(new InformarEleitor(8000));
            }
        }

        
    }
}
