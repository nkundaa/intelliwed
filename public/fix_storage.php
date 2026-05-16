<?php
// TEMPORARY FIX SCRIPT - DELETE AFTER USE

$target = __DIR__ . '/../storage/app/public';
$link   = __DIR__ . '/storage';

if (is_link($link)) {
    echo '<p style="color:orange">⚠️ Symlink already exists at public/storage</p>';
} elseif (file_exists($link)) {
    echo '<p style="color:red">❌ A folder named "storage" already exists in public/ — please remove it first via File Manager, then reload this page.</p>';
} else {
    if (symlink($target, $link)) {
        echo '<p style="color:green">✅ Storage symlink created successfully! Images should now be visible.</p>';
    } else {
        echo '<p style="color:red">❌ Failed to create symlink. Your host may not allow symlinks — contact your host or try the manual copy method below.</p>';
        // Fallback: copy files instead of symlinking
        echo '<p>Trying file copy fallback...</p>';
        if (!is_dir($link)) {
            mkdir($link, 0755, true);
        }
        $copied = 0;
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST) as $item) {
            $dest = $link . DIRECTORY_SEPARATOR . str_replace($target . DIRECTORY_SEPARATOR, '', $item->getPathname());
            if ($item->isDir()) {
                if (!is_dir($dest)) mkdir($dest, 0755, true);
            } else {
                copy($item->getPathname(), $dest);
                $copied++;
            }
        }
        echo '<p style="color:green">✅ Copied ' . $copied . ' files to public/storage/ as fallback.</p>';
    }
}

echo '<p><strong>⚠️ Delete this file (public/fix_storage.php) immediately after use!</strong></p>';

// Show current storage contents
echo '<hr><h3>Files in storage/app/public:</h3><pre>';
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS)) as $f) {
    echo $f->getPathname() . "\n";
}
echo '</pre>';
