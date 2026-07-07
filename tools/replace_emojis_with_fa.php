<?php

declare(strict_types=1);

$map = [
    '✅' => '<i class="fa-solid fa-circle-check" aria-hidden="true"></i>',
    '⚠️' => '<i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>',
    '🎓' => '<i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>',
    '📄' => '<i class="fa-solid fa-file-lines" aria-hidden="true"></i>',
    '📧' => '<i class="fa-solid fa-envelope" aria-hidden="true"></i>',
    '💬' => '<i class="fa-solid fa-comments" aria-hidden="true"></i>',
    '▶️' => '<i class="fa-solid fa-circle-play" aria-hidden="true"></i>',
    '▶' => '<i class="fa-solid fa-circle-play" aria-hidden="true"></i>',
    '❓' => '<i class="fa-solid fa-circle-question" aria-hidden="true"></i>',
    '📝' => '<i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>',
    '✏️' => '<i class="fa-solid fa-pen" aria-hidden="true"></i>',
    '👁' => '<i class="fa-solid fa-eye" aria-hidden="true"></i>',
    '📚' => '<i class="fa-solid fa-book-open" aria-hidden="true"></i>',
    '🗑' => '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
    '🌐' => '<i class="fa-solid fa-globe" aria-hidden="true"></i>',
    '⚙️' => '<i class="fa-solid fa-gear" aria-hidden="true"></i>',
    '🔗' => '<i class="fa-solid fa-link" aria-hidden="true"></i>',
    '⬇' => '<i class="fa-solid fa-download" aria-hidden="true"></i>',
    '📱' => '<i class="fa-solid fa-mobile-screen-button" aria-hidden="true"></i>',
    '📸' => '<i class="fa-solid fa-camera" aria-hidden="true"></i>',
    '💼' => '<i class="fa-solid fa-briefcase" aria-hidden="true"></i>',
    '👥' => '<i class="fa-solid fa-users" aria-hidden="true"></i>',
    '✉️' => '<i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>',
    '💾' => '<i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>',
    '🤝' => '<i class="fa-solid fa-handshake" aria-hidden="true"></i>',
    '🎤' => '<i class="fa-solid fa-microphone" aria-hidden="true"></i>',
    '📊' => '<i class="fa-solid fa-chart-column" aria-hidden="true"></i>',
    '🎯' => '<i class="fa-solid fa-bullseye" aria-hidden="true"></i>',
    '💡' => '<i class="fa-solid fa-lightbulb" aria-hidden="true"></i>',
    '📋' => '<i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>',
    '⭐' => '<i class="fa-solid fa-star" aria-hidden="true"></i>',
    '♾️' => '<i class="fa-solid fa-infinity" aria-hidden="true"></i>',
    '⏱' => '<i class="fa-solid fa-stopwatch" aria-hidden="true"></i>',
    '👋' => '<i class="fa-solid fa-hand" aria-hidden="true"></i>',
    '▾' => '<i class="fa-solid fa-chevron-down" aria-hidden="true"></i>',
    '✕' => '<i class="fa-solid fa-xmark" aria-hidden="true"></i>',
];

$baseDir = __DIR__ . '/../app/Views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));
$updated = 0;

foreach ($iterator as $file) {
    if (! $file->isFile() || strtolower($file->getExtension()) !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);
    if ($content === false) {
        continue;
    }

    $newContent = str_replace(array_keys($map), array_values($map), $content);
    if ($newContent !== $content) {
        file_put_contents($path, $newContent);
        $updated++;
    }
}

echo 'updated_files=' . $updated . PHP_EOL;
