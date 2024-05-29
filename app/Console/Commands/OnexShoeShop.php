<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class OnexShoeShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onex:shoe-shop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database migrate for shoe shop';

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
            $this->comment('System is migrating for shoe shop, Please wait...');

            DB::table('unit_master')->truncate();
            DB::table('unit_master')->insert([
                array(
                    'name' => 'Piece',
                    'short_name' => 'Pcs',
                    'description' => '1 Piece'
                ),
                array(
                    'name' => 'Box',
                    'short_name' => 'Box',
                    'description' => '1 Box'
                )
            ]);

            DB::table('brands')->truncate();
            DB::table('brands')->insert([
                array('name' => 'Difo')
            ]);

            DB::table('product_category')->truncate();
            DB::table('product_category')->insert([
                array(
                    'name' => 'Gents Shoes',
                    'description' => 'Shoes for men'
                ),
                array(
                    'name' => 'Ladies Shoes',
                    'description' => 'Shoes for ladies'
                )
            ]);

            DB::table('product_subcategory')->truncate();
            DB::table('product_subcategory')->insert([
                array('category_id' => 1, 'name' => 'Gents/Men'),
                array('category_id' => 2, 'name' => 'Ladies/Women')
            ]);

            DB::table('product_master')->truncate();
            DB::table('product_master')->insert([
                array('category_id' => 1, 'subcategory_id' => 1, 'name' => 'Gents Shoe'),
                array('category_id' => 2, 'subcategory_id' => 2, 'name' => 'Ladies Shoe')
            ]);

            DB::table('batches')->truncate();
            DB::table('batches')->insert([
                array('name' => 'Stock-Adjust', 'batch_no' => 'BC000000-000000')
            ]);

            DB::table('users')->insert([
                'hash_id' => 'aa0b3487-8b53-4b21-a260-de75e4829689',
                'unique_id' => '2600000197',
                'first_name' => 'Difo',
                'last_name' => 'Self',
                'email_id' => 'admin@difo.com',
                'user_category' => 2
            ]);

            $this->info('Done!');
        
        } catch (\Exception $e) {
            $this->error('Query execution failed');
            $this->comment($e->getMessage());
            //return $e->getMessage();
        }
    }
}
