<?php

    function __($key) {
        $language = $_SESSION['lang'] ?? 'ar';
        
        $file = __DIR__ . '/../lang/' . $language . '.php';
        if (!file_exists($file)) {
            return $key;
        }
    
        $translations = include($file);
        return $translations[$key] ?? $key;
    }
