<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\MetricHistoryRuns;

class MetricHistoryRunsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metric_history_runs')->insert([
            [
                'url' => 'https://example.com',
                'accessibility_metric' => 95.0,
                'pwa_metric' => 85.0,
                'performance_metric' => 90.0,
                'seo_metric' => 92.0,
                'best_practices_metric' => 88.0,
                'strategy_id' => 1,
                'created_at' => "2016-01-15 20:03:16",
                'updated_at' => "2016-01-15 20:03:16",
            ],
        ]);
    }
}
