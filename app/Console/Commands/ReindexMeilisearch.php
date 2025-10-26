<?php

namespace App\Console\Commands;

use App\Models\Addon;
use App\Models\Product;
use Exception;
use Illuminate\Console\Command;
use Meilisearch\Client;

class ReindexMeilisearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:reindex {model?}';
    protected $description = 'Recreează indexurile Meilisearch pentru toate modelele Scout';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );

        // Modelele tale care folosesc Scout
        $models = [
            Product::class,
            Addon::class,
        ];

        $modelArg = $this->argument('model');
        if ($modelArg) {
            $models = [app($modelArg)::class];
        }

        foreach ($models as $modelClass) {
            $model = new $modelClass;
            $indexName = $model->searchableAs();

            $this->info("🔄 Reindexez {$indexName}...");

            // Șterge indexul vechi, dacă există
            try {
                $client->index($indexName)->delete();
                $this->warn("🧹 Șters indexul vechi: {$indexName}");
            } catch (Exception $e) {
                $this->info("ℹ️ Indexul {$indexName} nu exista încă, continui...");
            }

            // Creează indexul nou
            $this->call('scout:import', ['model' => $modelClass]);
        }

        $this->info('✅ Toate indexurile au fost recreate cu succes!');
        return Command::SUCCESS;
    }
}
