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
        $file = base_path('backup_clean.sql');
        
        if (!file_exists($file)) {
            $this->error("backup_clean.sql not found!");
            return;
        }

        $sql = file_get_contents($file);

        // Find the INSERT INTO `products` query
        if (preg_match('/INSERT INTO `products` VALUES .*?;/s', $sql, $matches)) {
            $query = $matches[0];
            
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
