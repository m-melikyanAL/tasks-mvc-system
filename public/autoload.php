<?php
define("DS", DIRECTORY_SEPARATOR);
define("ROOT_PATH", dirname(__DIR__) . DS);
define("APP", ROOT_PATH . 'App' . DS);
define("CORE", APP . 'Core' . DS);
define("CONFIG", APP . 'Config' . DS);
define("CONTROLLERS", APP . 'Controllers' . DS);
define("MODELS", APP . 'Models' . DS);
define("VIEWS", APP . 'Views' . DS);
define("UPLOADS", ROOT_PATH . 'public' . DS . 'uploads' . DS);

// Ensure configuration files exist before requiring
if (file_exists(CONFIG . 'config.php')) {
    require_once(CONFIG . 'config.php');
} else {
    die("Configuration file not found: " . CONFIG . 'config.php');
}

if (file_exists(CONFIG . 'helpers.php')) {
    require_once(CONFIG . 'helpers.php');
} else {
    die("Helpers file not found: " . CONFIG . 'helpers.php');
}

// Add all relevant paths to include path
$includePaths = [ROOT_PATH, APP, CORE, VIEWS, CONTROLLERS, MODELS, CONFIG];
set_include_path(implode(PATH_SEPARATOR, $includePaths));

// Autoload function
spl_autoload_register(function ($class) {
    $classFile = str_replace('\\', DS, $class) . '.php';
    $paths = explode(PATH_SEPARATOR, get_include_path());

    foreach ($paths as $path) {
        $fullPath = $path . DS . $classFile;
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
    }
    throw new Exception("Class $class not found in any of the include paths.");
});

// Instantiate the application
try {
    new App(); // Fully qualified class name
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
