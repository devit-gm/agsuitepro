<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ImageService;
use Illuminate\Support\Facades\File;

class OptimizeExistingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize {--dry-run : Mostrar qué archivos se procesarían sin modificarlos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimiza y redimensiona todas las imágenes existentes en public/images a un máximo de 200x200px';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $imagesPath = public_path('images');
        
        if (!File::exists($imagesPath)) {
            $this->error('El directorio public/images no existe.');
            return 1;
        }
        
        $files = File::files($imagesPath);
        $imageFiles = array_filter($files, function($file) {
            $extension = strtolower($file->getExtension());
            return in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
        });
        
        if (empty($imageFiles)) {
            $this->info('No se encontraron imágenes para optimizar.');
            return 0;
        }
        
        $this->info('Encontradas ' . count($imageFiles) . ' imágenes.');
        
        if ($dryRun) {
            $this->warn('Modo DRY-RUN activado. No se modificará ningún archivo.');
        }
        
        $bar = $this->output->createProgressBar(count($imageFiles));
        $bar->start();
        
        $optimized = 0;
        $errors = 0;
        $totalSizeBefore = 0;
        $totalSizeAfter = 0;
        
        foreach ($imageFiles as $file) {
            $filename = $file->getFilename();
            $sizeBefore = $file->getSize();
            $totalSizeBefore += $sizeBefore;
            
            if (!$dryRun) {
                $result = ImageService::optimizeExisting($filename);
                
                if ($result) {
                    $optimized++;
                    $sizeAfter = filesize(public_path('images/' . $filename));
                    $totalSizeAfter += $sizeAfter;
                } else {
                    $errors++;
                    $totalSizeAfter += $sizeBefore;
                }
            } else {
                $optimized++;
                $totalSizeAfter += $sizeBefore; // En dry-run no cambia
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        if ($dryRun) {
            $this->info('Se procesarían ' . $optimized . ' imágenes.');
            $this->info('Tamaño total actual: ' . $this->formatBytes($totalSizeBefore));
        } else {
            $this->info('Procesadas: ' . $optimized . ' imágenes');
            if ($errors > 0) {
                $this->warn('Errores: ' . $errors . ' imágenes no pudieron procesarse');
            }
            $this->info('Tamaño antes: ' . $this->formatBytes($totalSizeBefore));
            $this->info('Tamaño después: ' . $this->formatBytes($totalSizeAfter));
            $saved = $totalSizeBefore - $totalSizeAfter;
            if ($saved > 0) {
                $percentage = round(($saved / $totalSizeBefore) * 100, 2);
                $this->info('Espacio ahorrado: ' . $this->formatBytes($saved) . ' (' . $percentage . '%)');
            }
        }
        
        return 0;
    }
    
    /**
     * Formatea bytes a una unidad legible
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
