<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Drafter\WorkspaceGambar;
use Illuminate\Support\Facades\Storage;

class CleanupOverlay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-overlay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus gambar overlay yang lebih dari 1 tahun';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldFiles = WorkspaceGambar::where('created_at', '<', now()->subYear())->get();

        foreach ($oldFiles as $file) {
            if ($file->foto_body) {
                $paths = json_decode($file->foto_body, true);
                foreach ($paths as $path) {
                    if (Storage::exists($path)) {
                        Storage::delete($path);
                    }
                }
            }

            $file->delete();
        }

        $this->info("Cleanup selesai, total: {$oldFiles->count()} file dihapus.");
    }
}
