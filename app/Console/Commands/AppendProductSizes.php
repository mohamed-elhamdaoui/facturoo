<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class AppendProductSizes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:append-sizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Appends the size of each product to its name if not already present.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all products that actually have a size defined
        $products = Product::whereNotNull('size')->where('size', '!=', '')->get();
        $updatedCount = 0;

        $this->info("Checking {$products->count()} products...");

        foreach ($products as $product) {
            $name = $product->name;
            $size = trim($product->size);

            // Check if the size is already part of the name (ignoring upper/lower case)
            if (!str_contains(strtolower($name), strtolower($size))) {
                
                $newName = trim($name) . ' ' . $size;
                $product->name = $newName;
                $product->save();
                
                $this->info("Updated: '{$name}' -> '{$newName}'");
                $updatedCount++;
            } else {
                $this->line("Skipped (Size already in name): '{$name}'");
            }
        }

        $this->info("Done! Successfully updated {$updatedCount} products.");
    }
}
