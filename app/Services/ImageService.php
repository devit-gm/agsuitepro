<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    /**
     * Procesa y redimensiona una imagen subida
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $destinationPath Ruta donde guardar (ej: 'public/images')
     * @param int $maxWidth Ancho máximo
     * @param int $maxHeight Alto máximo
     * @param int $quality Calidad de compresión (1-100)
     * @return string Nombre del archivo guardado
     */
    public static function processAndSave($file, $destinationPath = 'public/images', $maxWidth = 200, $maxHeight = 200, $quality = 85)
    {
        // Generar nombre único
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Crear manager
        $manager = new ImageManager(new Driver());
        
        // Procesar imagen
        $image = $manager->read($file);
        
        // Redimensionar manteniendo proporción (solo si es más grande)
        $image->scaleDown($maxWidth, $maxHeight);
        
        // Guardar con compresión
        $fullPath = storage_path('app/' . $destinationPath);
        
        // Crear directorio si no existe
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        $image->save($fullPath . '/' . $filename, $quality);
        
        return $filename;
    }
    
    /**
     * Elimina una imagen del almacenamiento
     * 
     * @param string $filename
     * @param string $path
     * @return bool
     */
    public static function delete($filename, $path = 'public/images')
    {
        $fullPath = storage_path('app/' . $path . '/' . $filename);
        
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        
        return false;
    }
    
    /**
     * Procesa imagen directamente desde public/images (migración de imágenes antiguas)
     * 
     * @param string $filename
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality
     * @return bool
     */
    public static function optimizeExisting($filename, $maxWidth = 200, $maxHeight = 200, $quality = 85)
    {
        $path = public_path('images/' . $filename);
        
        if (!file_exists($path)) {
            return false;
        }
        
        try {
            // Crear manager
            $manager = new ImageManager(new Driver());
            
            // Leer imagen
            $image = $manager->read($path);
            
            // Redimensionar manteniendo proporción (solo reduce, no aumenta)
            $image->scaleDown($maxWidth, $maxHeight);
            
            // Guardar optimizada
            $image->save($path, $quality);
            
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
