<?php

require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../routes/api.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if ($requestMethod === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if (!isset($routes[$requestMethod])) {
    http_response_code(405);
    echo json_encode(['error' => 'Methode HTTP non autorisee.']);
    exit;
}

if (!isset($routes[$requestMethod][$requestPath])) {
    http_response_code(404);
    echo json_encode(['error' => 'Route API introuvable.']);
    exit;
}

$handler = $routes[$requestMethod][$requestPath];

if (!function_exists($handler)) {
    http_response_code(500);
    echo json_encode(['error' => 'Handler API introuvable.']);
    exit;
}

try {
    $db = getDbConnection();
    $handler($db);
} catch (Throwable $exception) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erreur serveur.',
        'message' => $exception->getMessage(),
    ]);
}
