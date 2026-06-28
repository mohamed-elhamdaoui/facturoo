<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from backup_clean.sql';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = base_path('backup.utf8.sql');
        
        if (!file_exists($file)) {
            $this->error("backup.utf8.sql not found!");
            return;
        }

        $sql = file_get_contents($file);

        // Find the INSERT INTO `products` query
        if (preg_match('/INSERT INTO `products` VALUES .*?;/s', $sql, $matches)) {
            $query = $matches[0];
            
            // The old SQL dump doesn't specify columns, but our new DB has extra columns (stock_quantity, min_stock).
            // We need to inject the explicit column names so the insert works correctly.
            $query = str_replace(
                'INSERT INTO `products` VALUES',
                'INSERT INTO `products` (`id`, `name`, `category`, `size`, `price`, `image`, `created_at`, `updated_at`) VALUES',
                $query
            );

            // Fix corrupted French characters caused by bad mysqldump encoding
            $query = preg_replace('/P[^\w\'"\\\]+tes vrac/', 'Pâtes vrac', $query);
            $query = preg_replace('/P[^\w\'"\\\]+tes ptc/', 'Pâtes ptc', $query);
            
            // Clean up DB before inserting to avoid duplicates if it was already imported
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('products')->truncate();
            
            DB::unprepared($query);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info("Products imported successfully from backup!");
        } else {
            $this->error("Could not find the products INSERT statement in the SQL file.");
        }
    }
}
