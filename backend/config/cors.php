<?php
// agrinexus-api/config/cors.php
// Allow Vite dev server and configured production origins only.

$allowedOrigins = array_filter(array_map('trim', explode(',', getenv('ALLOWED_ORIGINS') ?: 'http://localhost:5173,http://127.0.0.1:5173')));
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if ($origin && in_array($origin, $allowedOrigins, true)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Vary: Origin');
    header('Access-Control-Allow-Credentials: true');
} elseif (!$origin) {
    header('Access-Control-Allow-Origin: *');
}

header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Expose-Headers: Retry-After');
header('Access-Control-Max-Age: 3600');

// Preflight — browsers send OPTIONS before POST/PUT with custom headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    if ($origin && !in_array($origin, $allowedOrigins, true)) {
        http_response_code(403);
        exit;
    }
    http_response_code(204);
    exit;
}
