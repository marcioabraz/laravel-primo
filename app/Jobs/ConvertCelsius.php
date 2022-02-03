<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConvertCelsius implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $farenheit;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $farenheit)
    {
        $this->farenheit = $farenheit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $celsius = ($this->farenheit - 32) * 5 / 9;
        } catch (\Throwable $th) {
            logger()->error('error na conversão. farenheit = ' . $this->farenheit);
        }
        logger()->info('Celsius = ' . $celsius);
    }
}
