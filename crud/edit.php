<?php
// crud/edit.php
require_once __DIR__ . '/../config/db_connect.php';
if (!isset($table) || !isset($fields) || !isset($labels) || !isset($primary_key)) {
  http_response_code(500);
  echo "Missing config (table/fields/labels/primary_key).";
  exit;
}

$id = $_GET['id'] ?? null;
if ($id === null) {
  http_response_code(400);
  echo "Missing id.";
  exit;
}

// Fetch existing
$stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$primary_key} = :id");
$stmt->execute([':id' => $id]);
$existing = $stmt->fetch();
if (!$existing) {
  http_response_code(404);
  echo "Record not found.";
  exit;
}

function fetch_fk_options($pdo, $fk) {
  $t = $fk['table']; $col = $fk['col']; $label = $fk['ref_label'];
  $stmt = $pdo->query("SELECT {$col} as id, {$label} as label FROM {$t} ORDER BY {$label} ASC");
  return $stmt->fetchAll();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sets = [];
  $values = [':id' => $id];
  foreach ($fields as $name => $meta) {
    if (!empty($meta['auto_increment']) || !empty($meta['auto']) || !empty($meta['primary'])) continue;

    $val = isset($_POST[$name]) ? trim($_POST[$name]) : null;

    if (!empty($meta['required']) && ($val === null || $val === '')) {
      $errors[] = ($labels[$name] ?? $name) . " is required.";
      continue;
    }

    if (!empty($meta['input']) && $meta['input'] === 'password' && !empty($meta['hash_password'])) {
      if ($val !== null && $val !== '') {
        $val = password_hash($val, PASSWORD_BCRYPT);
      } else {
        // skip updating password if left empty
        continue;
      }
    }

    if ($val === '' && isset($meta['nullable']) && $meta['nullable'] === true) {
      $val = null;
    }

    $sets[] = "{$name} = :{$name}";
    $values[':' . $name] = $val;
  }

  if (empty($errors) && !empty($sets)) {
    $sql = "UPDATE {$table} SET " . implode(',', $sets) . " WHERE {$primary_key} = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);
    $success = true;
  }
}

function render_header($title) {
  echo '<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>'
    . htmlspecialchars($title) . '</title><link rel="stylesheet" href="../../assets/style.css"></head><body>';
  echo '<div class="header"><h1>' . htmlspecialchars($title) . '</h1></div>';
  echo '<div class="nav"><div class="container"><a href="../../index.php">Home</a> <a href="list.php">Back to List</a></div></div>';
  echo '<div class="container"><div class="card">';
}

function render_footer() {
  echo '</div></div><div class="footer"><p>&copy; ' . date('Y') . ' Super Shop Management</p></div></body></html>';
}

render_header("Edit in " . ucfirst($table));

if ($success) {
  echo '<div class="flash">Record updated successfully.</div>';
  echo '<p><a class="btn primary" href="list.php">Go to List</a></p>';
}

if (!empty($errors)) {
  echo '<div class="flash error"><strong>Please fix the following:</strong><ul>';
  foreach ($errors as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
  echo '</ul></div>';
}

echo '<form method="post">';
foreach ($fields as $name => $meta) {
  $label = $labels[$name] ?? $name;
  if (!empty($meta['auto_increment']) || !empty($meta['auto']) || !empty($meta['primary'])) {
    echo '<div class="form-row"><label>'.htmlspecialchars($label).'</label>';
    echo '<input type="text" value="'.htmlspecialchars((string)$existing[$name]).'" disabled />';
    echo '</div>';
    continue;
  }

  $type = $meta['type'] ?? 'varchar';
  $input = $meta['input'] ?? null;
  $required = !empty($meta['required']) ? 'required' : '';
  $current = $existing[$name] ?? '';

  echo '<div class="form-row"><label for="'.htmlspecialchars($name).'">'.htmlspecialchars($label).'</label>';

  if (!empty($meta['foreign'])) {
    $opts = fetch_fk_options($pdo, $meta['foreign']);
    echo '<select name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" '.$required.'>';
    echo '<option value="">-- Select --</option>';
    foreach ($opts as $opt) {
      $sel = ($opt['id'] == $current) ? 'selected' : '';
      echo '<option '.$sel.' value="'.htmlspecialchars($opt['id']).'">'.htmlspecialchars($opt['label']).'</option>';
    }
    echo '</select>';
  } else if ($type === 'text') {
    echo '<textarea name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" rows="4">'.htmlspecialchars((string)$current).'</textarea>';
  } else if ($type === 'int' || $type === 'decimal') {
    $step = $type === 'decimal' ? '0.01' : '1';
    echo '<input type="number" step="'.$step.'" name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" value="'.htmlspecialchars((string)$current).'" '.$required.' />';
  } else if ($type === 'date') {
    echo '<input type="date" name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" value="'.htmlspecialchars((string)$current).'" '.$required.' />';
  } else if ($type === 'enum' && !empty($meta['options'])) {
    echo '<select name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" '.$required.'>';
    foreach ($meta['options'] as $opt) {
      $sel = ($opt == $current) ? 'selected' : '';
      echo '<option '.$sel.' value="'.htmlspecialchars($opt).'">'.htmlspecialchars(ucfirst($opt)).'</option>';
    }
    echo '</select>';
  } else if ($input === 'password') {
    echo '<input type="password" name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" placeholder="Leave blank to keep unchanged" />';
  } else {
    echo '<input type="text" name="'.htmlspecialchars($name).'" id="'.htmlspecialchars($name).'" value="'.htmlspecialchars((string)$current).'" '.$required.' />';
  }
  echo '</div>';
}
echo '<button class="btn primary" type="submit">Update</button>';
echo '</form>';

render_footer();