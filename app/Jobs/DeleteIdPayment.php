<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\DataPayment;
use App\Events\StatusDeleted;

class DeleteIdPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $idPayment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($idPayment)
    {
        $this->idPayment = $idPayment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DataPayment::destroy($this->idPayment);
        event(new StatusDeleted($this->idPayment));
    }
}
