<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Locate autoloader (supports both production/truant_app and standard structure)
$autoloader = __DIR__ . '/../production/truant_app/vendor/autoload.php';
if (!file_exists($autoloader)) {
    $autoloader = __DIR__ . '/../vendor/autoload.php';
}

if (!file_exists($autoloader)) {
    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html><head><title>Setup Required — Truant</title><style>body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:#060d1a;color:#f1f5f9;padding:40px 20px;text-align:center;} .box{max-width:550px;margin:50px auto;background:#0d1b2e;border:1px solid #1a2d45;padding:32px;border-radius:12px;box-shadow:0 10px 25px rgba(0,0,0,0.5);} h1{font-size:22px;color:#ef4444;margin-bottom:12px;} p{color:#94a3b8;font-size:14px;line-height:1.6;margin-bottom:24px;} a{color:#060d1a;background:#38bdf8;font-weight:700;font-size:14px;padding:12px 24px;border-radius:8px;text-decoration:none;display:inline-block;} a:hover{background:#7dd3fc;}</style></head><body>';
    echo '<div class="box">';
    echo '<h1>Application Initial Setup Required</h1>';
    echo '<p>The <code>vendor/</code> directory is missing because of the recent folder restructure. Run the setup script to install dependencies and configure <code>.env</code>.</p>';
    echo '<a href="/setup.php">Run Setup Script (setup.php) &rarr;</a>';
    echo '</div></body></html>';
    exit;
}

// 1. Determine if application is in maintenance mode
$maintenance = dirname($autoloader) . '/../storage/framework/maintenance.php';
if (file_exists($maintenance)) {
    require $maintenance;
}

// 2. Register Composer autoloader
require $autoloader;

// 3. Bootstrap Laravel and handle request
$bootstrap = dirname($autoloader) . '/../bootstrap/app.php';
/** @var Application $app */
$app = require_once $bootstrap;

// Set public path to public_html
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());

