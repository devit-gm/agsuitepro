<?php
/**
 * Script para generar splash screens de iOS desde el logo PWA
 */

if ($argc < 2) {
    echo "Uso: php generate-splash-screens.php <carpeta_pwa>\n";
    exit(1);
}

$carpetaPWA = $argv[1];
$basePath = __DIR__ . "/public/" . $carpetaPWA;
$logoPath = $basePath . "/icon-512x512.png";

if (!file_exists($logoPath)) {
    echo "Error: No se encuentra el logo en $logoPath\n";
    exit(1);
}

$splashSizes = [
    ['width' => 1125, 'height' => 2436, 'name' => 'splash-1125x2436.png'],
    ['width' => 828, 'height' => 1792, 'name' => 'splash-828x1792.png'],
    ['width' => 1242, 'height' => 2688, 'name' => 'splash-1242x2688.png'],
    ['width' => 1170, 'height' => 2532, 'name' => 'splash-1170x2532.png'],
    ['width' => 1284, 'height' => 2778, 'name' => 'splash-1284x2778.png'],
    ['width' => 1179, 'height' => 2556, 'name' => 'splash-1179x2556.png'],
    ['width' => 1290, 'height' => 2796, 'name' => 'splash-1290x2796.png'],
    ['width' => 1536, 'height' => 2048, 'name' => 'splash-1536x2048.png'],
    ['width' => 1668, 'height' => 2224, 'name' => 'splash-1668x2224.png'],
    ['width' => 1668, 'height' => 2388, 'name' => 'splash-1668x2388.png'],
    ['width' => 2048, 'height' => 2732, 'name' => 'splash-2048x2732.png'],
];

$logo = imagecreatefrompng($logoPath);
if (!$logo) {
    echo "Error: No se pudo cargar el logo\n";
    exit(1);
}

$logoWidth = imagesx($logo);
$logoHeight = imagesy($logo);

echo "Generando splash screens...\n\n";

foreach ($splashSizes as $size) {
    $width = $size['width'];
    $height = $size['height'];
    $filename = $size['name'];
    
    $splash = imagecreatetruecolor($width, $height);
    $bgColor = imagecolorallocate($splash, 255, 255, 255);
    imagefill($splash, 0, 0, $bgColor);
    
    $maxLogoSize = min($width * 0.3, 300);
    $logoScale = $maxLogoSize / $logoWidth;
    $newLogoWidth = (int)($logoWidth * $logoScale);
    $newLogoHeight = (int)($logoHeight * $logoScale);
    
    $logoX = (int)(($width - $newLogoWidth) / 2);
    $logoY = (int)(($height - $newLogoHeight) / 2);
    
    imagealphablending($splash, true);
    imagesavealpha($splash, true);
    imagecopyresampled(
        $splash, $logo,
        $logoX, $logoY, 0, 0,
        $newLogoWidth, $newLogoHeight,
        $logoWidth, $logoHeight
    );
    
    $outputPath = $basePath . '/' . $filename;
    if (imagepng($splash, $outputPath, 9)) {
        echo "✓ $filename ({$width}x{$height})\n";
    } else {
        echo "✗ Error: $filename\n";
    }
    
    imagedestroy($splash);
}

imagedestroy($logo);
echo "\n¡Completado!\n";
