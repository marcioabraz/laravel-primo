<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeSum implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $num1;
    public $num2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $num1, int $num2)
    {
        $this->num1 = $num1;
        $this->num2 = $num2;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $soma = $this->num1 + $this->num2;
        } catch (\Throwable $th) {
            logger()->error('Soma erro: ' . $this->num1 . ' + ' . $this->num2);
        }
        logger()->info('Soma = ' . $soma);
    }
}
