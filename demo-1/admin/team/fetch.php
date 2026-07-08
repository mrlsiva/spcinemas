<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$stmt = $connect->query("SELECT * FROM team_members ORDER BY sort_order ASC, id ASC");
$rows = $stmt->fetchAll();

$output = '
 <table class="table table-bordered table-striped">
  <thead>
  <tr>
   <th></th>
   <th>#</th>
   <th>Name</th>
   <th>Role</th>
   <th>Status</th>
   <th>Edit</th>
   <th>Delete</th>
  </tr>
  </thead>
  <tbody>
';

if (count($rows) > 0) {
    $count = 0;
    foreach ($rows as $row) {
        $count++;
        $is_enabled = $row["status"] === 'enabled';
        $output .= '
  <tr data-id="' . (int)$row["id"] . '">
   <td class="drag-handle text-center"><i class="glyphicon glyphicon-resize-vertical"></i></td>
   <td class="sr-no">' . $count . '</td>
   <td>' . htmlspecialchars($row["name"]) . '</td>
   <td>' . htmlspecialchars($row["role"]) . '</td>
   <td><button type="button" class="btn btn-xs btn-toggle-status ' . ($is_enabled ? 'btn-success' : 'btn-default') . '" id="' . (int)$row["id"] . '">' . ($is_enabled ? 'Enabled' : 'Disabled') . '</button></td>
   <td><button type="button" class="btn btn-warning btn-xs edit" id="' . (int)$row["id"] . '">Edit</button></td>
   <td><button type="button" class="btn btn-danger btn-xs delete" id="' . (int)$row["id"] . '">Delete</button></td>
  </tr>
  ';
    }
} else {
    $output .= '<tr><td colspan="7" align="center">No Data Found</td></tr>';
}

$output .= '</tbody></table>';
echo $output;
