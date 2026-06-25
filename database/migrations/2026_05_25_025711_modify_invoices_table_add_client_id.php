<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add client_id as nullable first
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('total');
        });

        // 2. Migrate data: Get unique customer_names and create clients
        $invoices = DB::table('invoices')->get();
        $clientMap = [];
        foreach ($invoices as $inv) {
            if (!empty($inv->customer_name)) {
                $customerName = trim($inv->customer_name);
                if (!isset($clientMap[$customerName])) {
                    $clientId = DB::table('clients')->insertGetId([
                        'name'       => $customerName,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $clientMap[$customerName] = $clientId;
                }
                
                DB::table('invoices')
                    ->where('id', $inv->id)
                    ->update(['client_id' => $clientMap[$customerName]]);
            }
        }

        // 3. Make client_id constrained and drop customer_name
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('customer_name');
            $table->foreignId('client_id')->nullable(false)->change()->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->string('customer_name')->after('id')->nullable();
        });

        // Restore customer_name from client names
        $invoices = DB::table('invoices')->get();
        foreach ($invoices as $inv) {
            if ($inv->client_id) {
                $clientName = DB::table('clients')->where('id', $inv->client_id)->value('name');
                DB::table('invoices')->where('id', $inv->id)->update(['customer_name' => $clientName]);
            }
        }

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('client_id');
        });
    }
};
