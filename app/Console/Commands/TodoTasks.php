<?php

namespace App\Console\Commands;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Console\Command;

class TodoTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TodoTasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all uncompleted work';

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
     * @return mixed
     */
    public function handle()
    {
        $products = Product::where('pospal_id',null)->get();
        $this->info("Products that don't have pospal barcode(id): ");
        foreach ($products as $product){
            $this->info('product id: '.$product->id);
        }
        $this->info("Total: ".count($products)."\n");

        $products = Product::where('RRP','0')->get();
        $this->info("Products that don't have RRP price: ");
        foreach ($products as $product){
            $this->info('product id: '.$product->id);
        }
        $this->info("Total: ".count($products)."\n");

        $brands = Brand::all();
        $this->info("Brands that don't have any products: ");
        $num = 0;
        foreach ($brands as $brand){
            if($brand->products->isEmpty()){
                $num++;
                $this->info('brand id: '.$brand->id);
            }
        }
        $this->info("Total: ".$num."\n");

        $categories = Category::all();
        $this->info("Categories that don't have any products: ");
        $num = 0;
        foreach ($categories as $category){
            if($category->products->isEmpty()){
                $num++;
                $this->info('category id: '.$category->id);
            }
        }
        $this->info("Total: ".$num."\n");
    }
}
