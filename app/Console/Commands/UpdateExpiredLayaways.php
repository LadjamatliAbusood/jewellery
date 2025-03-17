<?php

namespace App\Console\Commands;

use App\Models\CustomerLayawayInfo;
use App\Models\CustomerStorage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateExpiredLayaways extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

   
    protected $signature = 'update:expired_layaways';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update layaway statuses when they exceed their plan duration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       
        $layaways = CustomerLayawayInfo::whereHas('storage', function ($query) {
            $query->where('status', '!=', 5);
        })->get();

        foreach ($layaways as $layaway) {
            $expirationDate = match ($layaway->plan) {
                1 => Carbon::parse($layaway->created_at)->addDays(15),
                2 => Carbon::parse($layaway->created_at)->addMonths(3),
                4 => Carbon::parse($layaway->created_at)->addMonths(4),
                5 => Carbon::parse($layaway->created_at)->addMonths(6),
                default => null,
            };

            if ($expirationDate && Carbon::now()->greaterThan($expirationDate)) {
                CustomerStorage::where('layaway_id', $layaway->id)
                    ->where('status', '!=', 5)
                    ->update(['status' => 5]);
            }
        }

        $this->info("Expired layaways have been updated.");
    }
}
