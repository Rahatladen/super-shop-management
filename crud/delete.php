<?php
// crud/delete.php
require_once __DIR__ . '/../config/db_connect.php';
if (!isset($table) || !isset($primary_key)) {
  http_response_code(500);
  echo "Missing config (table/primary_key).";
  exit;
}

$id = $_GET['id'] ?? null;
if ($id === null) {
  http_response_code(400);
  echo "Missing id.";
  exit;
}

$stmt = $pdo->prepare("DELETE FROM {$table} WHERE {$primary_key} = :id");
try {
  $stmt->execute([':id' => $id]);
  header("Location: list.php?deleted=1");
  exit;
} catch (PDOException $e) {
  http_response_code(500);
  echo "Delete failed: " . htmlspecialchars($e->getMessage());
  exit;
}