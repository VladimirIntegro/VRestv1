<?php
// Autoload all project classes
$projectPath = __DIR__ . DIRECTORY_SEPARATOR;

spl_autoload_register(function($class) use ($projectPath) {
    $parts = explode('\\', $class);
    if(count($parts) > 1) {
        $classFile = $projectPath . array_shift($parts) . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $parts) . ".php";
    } else {
        $classFile = $projectPath . DIRECTORY_SEPARATOR . $class . '.php';
    }
    if(stream_resolve_include_path($classFile) === false) return;
    include $classFile;
});
