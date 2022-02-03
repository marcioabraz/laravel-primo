<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Notifications\DivMade;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class MakeDiv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $num1;
    public $num2;
    public $userId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $num1, int $num2, int $userId)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            if($this->num2 === 0 ){
                $user = User::find($this->userId);
                logger()->info('Divisão por zero');
                $user->notify(
                    new DivMade(
                    'Erro',
                    'Divisão por zero'
                    )
                );
            }

            $div = $this->num1 / $this->num2;
            $user = User::find($this->userId);
            logger()->info('Div = ' . $div);
            $user->notify(new DivMade
            (
                'Sucesso',
                'Div = ' . $div
            )
        );
        } catch (\Throwable $th) {
            logger()->error('Erro = ' . $th);
        }
    }
}