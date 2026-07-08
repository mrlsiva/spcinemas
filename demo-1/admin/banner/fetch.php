<?php
require_once __DIR__ . '/../auth.php';
require_admin_login_ajax();
require __DIR__ . '/../Dbconfig.php';

$stmt = $connect->query("SELECT * FROM banner_slides ORDER BY sort_order ASC, id ASC");
$rows = $stmt->fetchAll();

$output = '
 <table class="table table-bordered table-striped">
  <thead>
  <tr>
   <th></th>
   <th>#</th>
   <th>Image</th>
   <th>Mobile</th>
   <th>Title</th>
   <th>Category</th>
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
   <td><img src="../assets/img/portfolio/1920/' . htmlspecialchars($row["image"]) . '" class="img-thumbnail" width="120" height="70" /></td>
   <td>' . ($row["mobile_image"] ? '<img src="../assets/img/portfolio/mobile/' . htmlspecialchars($row["mobile_image"]) . '" class="img-thumbnail" width="70" height="70" />' : '<span class="text-muted">&mdash;</span>') . '</td>
   <td>' . htmlspecialchars($row["title"]) . '</td>
   <td>' . htmlspecialchars($row["category"]) . '</td>
   <td><button type="button" class="btn btn-xs btn-toggle-status ' . ($is_enabled ? 'btn-success' : 'btn-default') . '" id="' . (int)$row["id"] . '">' . ($is_enabled ? 'Enabled' : 'Disabled') . '</button></td>
   <td><button type="button" class="btn btn-warning btn-xs edit" id="' . (int)$row["id"] . '">Edit</button></td>
   <td><button type="button" class="btn btn-danger btn-xs delete" id="' . (int)$row["id"] . '">Delete</button></td>
  </tr>
  ';
    }
} else {
    $output .= '<tr><td colspan="9" align="center">No Data Found</td></tr>';
}

$output .= '</tbody></table>';
echo $output;
