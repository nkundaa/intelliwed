<?php
// TEMPORARY CACHE CLEAR SCRIPT - DELETE AFTER USE

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$commands = ['config:clear', 'cache:clear', 'view:clear', 'route:clear'];
foreach ($commands as $cmd) {
    $kernel->call($cmd);
    echo '<p style="color:green">✅ php artisan ' . $cmd . ' — done</p>';
}

echo '<p><strong>⚠️ Delete this file (public/clear_cache.php) immediately after use!</strong></p>';
