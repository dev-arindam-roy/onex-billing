<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class OnexSystemReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onex:system-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'System Database Reset - For New Installation';

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
        try {

            $isConfirm = $this->ask("Are you sure, You want to reset the system? (Y/N)");
            if (strtolower($isConfirm) == "y") {
                $this->comment('System is resetting..., Please wait...');

                $count = 20;
                $this->output->progressStart($count);

                DB::table('users')->where('id', '!=', 1)->delete();
                DB::table('user_roles')->where('user_id', '!=', 1)->delete();
                DB::table('users_profile')->truncate();
                
                DB::table('product_subcategory')->truncate();
                DB::table('product_category')->truncate();

                DB::table('product_variants')->truncate();
                DB::table('product_master')->truncate();
                DB::table('product_meta_fields')->truncate();
                DB::table('product_images')->truncate();
                DB::table('product_bundle_free')->truncate();
                
                DB::table('unit_master')->truncate();
                DB::table('brands')->truncate();
                
                DB::table('batch_products')->truncate();
                DB::table('batches')->truncate();

                DB::table('sale_products')->truncate();
                DB::table('sales')->truncate();
                
                DB::table('purchase_products')->truncate();
                DB::table('purchase')->truncate();

                DB::table('company_information')->truncate();

                for ($i = 1; $i <= 20; $i++) {
                    sleep(1);
                    $this->output->progressAdvance();
                }

                $this->output->progressFinish();

                $this->info('System has been reset successfully!');
            } else {
                $this->line('Cancelled!!');
            }
        
        } catch (\Exception $e) {
            $this->error('Query execution failed');
            $this->comment($e->getMessage());
            //return $e->getMessage();
        }
    }
}
