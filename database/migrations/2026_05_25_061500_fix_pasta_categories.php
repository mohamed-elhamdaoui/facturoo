<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Product;

return new class extends Migration
{
    public function up(): void
    {
        // Update category for products with any variation of P+ or P├ótes to 'Pâtes vrac' if size is 5kg or 10kg
        Product::whereIn('category', ['P+', 'P├ótes vrac', 'P+tes vrac', 'P\u{251c}\u{00f3}tes vrac'])
            ->whereIn('size', ['5kg', '10kg'])
            ->update(['category' => 'Pâtes vrac']);

        // Update category for products with any variation of P+ or P├ótes to 'Pâtes ptc' if size is 250g or 500g
        Product::whereIn('category', ['P+', 'P├ótes ptc', 'P+tes ptc', 'P\u{251c}\u{00f3}tes ptc'])
            ->whereIn('size', ['250g', '500g'])
            ->update(['category' => 'Pâtes ptc']);
    }

    public function down(): void
    {
        Product::where('category', 'Pâtes vrac')->update(['category' => 'P+']);
        Product::where('category', 'Pâtes ptc')->update(['category' => 'P+']);
    }
};
