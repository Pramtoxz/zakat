<?php

/**
 * Sistem Manajemen Zakat - MPZ Alumni FK Unand Padang
 * Copyright (c) 2025 Pramudito Metra
 * 
 * INTEGRITY CHECKER - DO NOT REMOVE OR MODIFY
 */

class IntegrityChecker
{
    private const AUTHOR = 'Pramudito Metra';
    private const EMAIL = 'pramuditometra@gmail.com';
    private const REPOSITORY = 'https://github.com/pramuditometra/zakat-mpz';
    
    public static function checkCopyright(): bool
    {
        $files = [
            'README.md',
            'LICENSE', 
            'SECURITY.md',
            'app/Controllers/BaseController.php'
        ];
        
        foreach ($files as $file) {
            if (!file_exists($file)) {
                return false;
            }
            
            $content = file_get_contents($file);
            if (strpos($content, self::AUTHOR) === false) {
                return false;
            }
        }
        
        return true;
    }
    
    public static function getOriginInfo(): array
    {
        exec('git remote get-url origin 2>/dev/null', $output, $return_code);
        
        return [
            'original_repo' => self::REPOSITORY,
            'current_origin' => $return_code === 0 ? trim($output[0] ?? '') : null,
            'is_legitimate' => $return_code === 0 && strpos($output[0] ?? '', 'pramuditometra') !== false
        ];
    }
    
    public static function displayWarning(): void
    {
        if (!self::checkCopyright()) {
            echo "\n⚠️  COPYRIGHT VIOLATION DETECTED!\n";
            echo "Original author information has been removed.\n";
            echo "This violates the MIT License terms.\n\n";
        }
        
        $origin = self::getOriginInfo();
        if (!$origin['is_legitimate']) {
            echo "\n🚨 POTENTIAL COPYRIGHT THEFT DETECTED!\n";
            echo "Original repository: " . self::REPOSITORY . "\n";
            echo "Current origin: " . ($origin['current_origin'] ?? 'Unknown') . "\n";
            echo "Author: " . self::AUTHOR . " (" . self::EMAIL . ")\n\n";
        }
    }
}

// Auto-check on file include
if (php_sapi_name() !== 'cli') {
    IntegrityChecker::displayWarning();
}
