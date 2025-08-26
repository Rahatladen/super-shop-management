<?php
// crud/list.php
require_once __DIR__ . '/../config/db_connect.php';
if (!isset($table) || !isset($fields) || !isset($labels) || !isset($primary_key)) {
  http_response_code(500);
  echo "Missing config (table/fields/labels/primary_key).";
  exit;
}

function render_header($title) {
  echo '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'
    . htmlspecialchars($title) . '</title><link rel="stylesheet" href="../../assets/style.css"></head><body>';
  echo '<div class="header"><h1>' . htmlspecialchars($title) . '</h1></div>';
  echo '<div class="nav"><div class="container"><a href="../../index.php">Home</a> <a href="create.php">Create New</a></div></div>';
  echo '<div class="container"><div class="card">';
}

function render_footer() {
  echo '</div></div><div class="footer"><p>&copy; ' . date('Y') . ' Super Shop Management</p></div></body></html>';
}

render_header(ucfirst($table) . ' List');

// Simple pagination
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

// Count
$total = (int)$pdo->query("SELECT COUNT(*) AS c FROM {$table}")->fetch()['c'];

// Fetch rows
$stmt = $pdo->prepare("SELECT * FROM {$table} ORDER BY {$primary_key} DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

if (!$rows) {
  echo '<p>No records yet. <a class="btn primary" href="create.php">Create the first one</a></p>';
} else {
  echo '<table class="table"><thead><tr>';
  foreach ($fields as $name => $meta) {
    if (!empty($meta['hidden'])) continue;
    echo '<th>' . htmlspecialchars($labels[$name] ?? $name) . '</th>';
  }
  echo '<th>Actions</th>';
  echo '</tr></thead><tbody>';

  foreach ($rows as $row) {
    echo '<tr>';
    foreach ($fields as $name => $meta) {
      if (!empty($meta['hidden'])) continue;
      $val = $row[$name] ?? '';
      if (!empty($meta['type']) && $meta['type'] === 'datetime' && !empty($val)) {
        $val = htmlspecialchars($val);
      } else {
        $val = htmlspecialchars((string)$val);
      }
      echo '<td>' . $val . '</td>';
    }
    $id = urlencode($row[$primary_key]);
    echo '<td><a class="btn" href="edit.php?id='.$id.'">Edit</a> <a class="btn danger" href="delete.php?id='.$id.'" onclick="return confirm(\'Delete this record?\')">Delete</a></td>';
    echo '</tr>';
  }
  echo '</tbody></table>';

  // Pagination links
  $pages = max(1, (int)ceil($total / $perPage));
  if ($pages > 1) {
    echo '<p>Page: ';
    for ($p=1; $p <= $pages; $p++) {
      if ($p == $page) echo '<strong>'.$p.'</strong> ';
      else echo '<a href="?page='.$p.'">'.$p.'</a> ';
    }
    echo '</p>';
  }
}

render_footer();