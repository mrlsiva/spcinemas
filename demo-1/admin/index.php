<?php
require_once __DIR__ . '/auth.php';
require_admin_login();
require __DIR__ . '/Dbconfig.php';
$publications = require __DIR__ . '/publications.php';
try {
    $custom_publication_names = $connect->query("SELECT publication FROM publication_logos")->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $custom_publication_names = [];
}
$all_publication_names = array_values(array_unique(array_merge(array_keys($publications), $custom_publication_names)));
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta content="width=device-width, initial-scale=1.0" name="viewport">
 <title>SP Cinemas || Admin</title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style type="text/css">
  .drag-handle { cursor: move; }
  tr.ui-sortable-helper { background: #f5f5f5; box-shadow: 0 2px 6px rgba(0,0,0,0.3); display: table; }
  .header-row { display: flex; align-items: center; justify-content: space-between; }
  .header-actions .btn { margin-left: 8px; }
  body { padding-bottom: 60px; }
  .repeat-row { display: flex; gap: 8px; margin-bottom: 8px; align-items: center; }
  .repeat-row .form-control { flex: 1 1 auto; }
  .repeat-row-remove { flex: 0 0 auto; }
  .repeat-section-label { display: flex; align-items: center; justify-content: space-between; }
  .repeat-row-logo-input { flex: 1 1 150px; }
  .repeat-row-logo-preview { flex: 0 0 auto; max-height: 30px; max-width: 60px; display: none; }
 </style>
</head>
<body>
 <br />
 <div class="container">
  <div class="header-row">
   <h3>SP Cinemas Admin</h3>
   <div class="header-actions">
    <a href="../index.php" target="_blank" class="btn btn-default" title="View Site"><i class="glyphicon glyphicon-globe"></i> View Site</a>
    <a href="logout.php" class="btn btn-default" title="Logout"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
   </div>
  </div>
  <br />

  <ul class="nav nav-tabs" role="tablist">
   <li role="presentation" class="active"><a href="#banner-tab" aria-controls="banner-tab" role="tab" data-toggle="tab">Home Banner</a></li>
   <li role="presentation"><a href="#team-tab" aria-controls="team-tab" role="tab" data-toggle="tab">Our Team</a></li>
   <li role="presentation"><a href="#projects-tab" aria-controls="projects-tab" role="tab" data-toggle="tab">Projects</a></li>
  </ul>

  <div class="tab-content">

   <div role="tabpanel" class="tab-pane active" id="banner-tab">
    <br />
    <div class="header-row">
     <h4>Home Banner Slides</h4>
     <button type="button" class="btn btn-primary" data-add="banner"><i class="glyphicon glyphicon-plus"></i> Add Slide</button>
    </div>
    <br />
    <div class="table-responsive" id="banner_table"></div>
   </div>

   <div role="tabpanel" class="tab-pane" id="team-tab">
    <br />
    <div class="header-row">
     <h4>Our Team</h4>
     <button type="button" class="btn btn-primary" data-add="team"><i class="glyphicon glyphicon-plus"></i> Add Member</button>
    </div>
    <br />
    <div class="table-responsive" id="team_table"></div>
   </div>

   <div role="tabpanel" class="tab-pane" id="projects-tab">
    <br />
    <div class="header-row">
     <h4>Projects</h4>
     <button type="button" class="btn btn-primary" data-add="projects"><i class="glyphicon glyphicon-plus"></i> Add Project</button>
    </div>
    <br />
    <div class="table-responsive" id="projects_table"></div>
   </div>

  </div>
 </div>

 <!-- Banner: Add / Edit modal -->
 <div id="banner_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="POST" id="banner_form" enctype="multipart/form-data">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" id="banner_modal_title">Add Slide</h4>
     </div>
     <div class="modal-body">
      <input type="hidden" name="id" id="banner_id" value="" />
      <div class="form-group">
       <label>Current Web Image</label><br>
       <img id="banner_current_image" src="" alt="" style="max-width:200px;max-height:120px;display:none;" class="img-thumbnail">
      </div>
      <div class="form-group">
       <label>Web Image <span id="banner_image_required">*</span></label>
       <input type="file" name="image" id="banner_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" />
       <small class="text-muted">JPG, JPEG, PNG, GIF or WebP, max 2MB. 1920px wide recommended. Shown on desktop/tablet screens.</small>
      </div>
      <div class="form-group">
       <label>Current Mobile Image</label><br>
       <img id="banner_current_mobile_image" src="" alt="" style="max-width:150px;max-height:200px;display:none;" class="img-thumbnail">
      </div>
      <div class="form-group">
       <label>Mobile Image (optional)</label>
       <input type="file" name="mobile_image" id="banner_mobile_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" />
       <small class="text-muted">JPG, JPEG, PNG, GIF or WebP, max 2MB. Shown on phone screens (767px and narrower) instead of the Web Image, if provided.</small>
      </div>
      <div class="form-group">
       <label>Title</label>
       <input type="text" name="title" id="banner_title" class="form-control" />
       <small class="text-muted">You can use &lt;br&gt; to force a line break.</small>
      </div>
      <div class="form-group">
       <label>Category (caption label)</label>
       <input type="text" name="category" id="banner_category" class="form-control" />
      </div>
      <div class="form-group">
       <label>Link URL</label>
       <input type="text" name="link_url" id="banner_link_url" class="form-control" placeholder="#" />
      </div>
      <div class="form-group">
       <label>Status</label>
       <select name="status" id="banner_status" class="form-control">
        <option value="enabled">Enabled</option>
        <option value="disabled">Disabled</option>
       </select>
      </div>
     </div>
     <div class="modal-footer">
      <input type="submit" class="btn btn-info" value="Save" />
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
    </form>
   </div>
  </div>
 </div>

 <!-- Team: Add / Edit modal -->
 <div id="team_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="POST" id="team_form">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" id="team_modal_title">Add Member</h4>
     </div>
     <div class="modal-body">
      <input type="hidden" name="id" id="team_id" value="" />
      <div class="form-group">
       <label>Name</label>
       <input type="text" name="name" id="team_name" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Role</label>
       <input type="text" name="role" id="team_role" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Bio</label>
       <textarea name="bio" id="team_bio" class="form-control" rows="6" required></textarea>
      </div>
      <div class="form-group">
       <label>Status</label>
       <select name="status" id="team_status" class="form-control">
        <option value="enabled">Enabled</option>
        <option value="disabled">Disabled</option>
       </select>
      </div>
     </div>
     <div class="modal-footer">
      <input type="submit" class="btn btn-info" value="Save" />
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
    </form>
   </div>
  </div>
 </div>

 <!-- Projects: Add / Edit modal -->
 <div id="projects_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
   <div class="modal-content">
    <form method="POST" id="projects_form" enctype="multipart/form-data">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title" id="projects_modal_title">Add Project</h4>
     </div>
     <div class="modal-body">
      <input type="hidden" name="id" id="projects_id" value="" />
      <div class="form-group">
       <label>Current Image</label><br>
       <img id="projects_current_image" src="" alt="" style="max-width:200px;max-height:120px;display:none;" class="img-thumbnail">
      </div>
      <div class="form-group">
       <label>Image <span id="projects_image_required">*</span></label>
       <input type="file" name="image" id="projects_image" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" />
       <small class="text-muted">JPG, JPEG, PNG, GIF or WebP, max 2MB. 940px wide recommended.</small>
      </div>
      <div class="form-group">
       <label>Title</label>
       <input type="text" name="title" id="projects_title" class="form-control" required />
      </div>
      <div class="form-group">
       <label>Category</label>
       <select name="category" id="projects_category" class="form-control">
        <option value="branding">Films</option>
        <option value="people">Web Series</option>
        <option value="nature">Commercial</option>
       </select>
      </div>
      <div class="form-group">
       <label>Link URL</label>
       <input type="text" name="link_url" id="projects_link_url" class="form-control" placeholder="#" />
      </div>
      <div class="form-group">
       <label>Production credits</label>
       <textarea name="credits" id="projects_credits" class="form-control" rows="3" placeholder="One credit line per row, e.g.&#10;SP Cinemas Production"></textarea>
      </div>
      <div class="form-group">
       <label>Synopsis (shown in the project's popup)</label>
       <textarea name="synopsis" id="projects_synopsis" class="form-control" rows="4"></textarea>
      </div>
      <div class="form-group">
       <div class="repeat-section-label">
        <label>Videos (shown in the popup)</label>
        <button type="button" class="btn btn-default btn-xs" id="projects_add_video"><i class="glyphicon glyphicon-plus"></i> Add video</button>
       </div>
       <div id="projects_videos_rows"></div>
      </div>
      <div class="form-group">
       <div class="repeat-section-label">
        <label>Press reviews (shown in the popup)</label>
        <button type="button" class="btn btn-default btn-xs" id="projects_add_review"><i class="glyphicon glyphicon-plus"></i> Add review</button>
       </div>
       <div id="projects_reviews_rows"></div>
       <datalist id="projects_publications_list"></datalist>
      </div>
      <div class="form-group">
       <label>Status</label>
       <select name="status" id="projects_status" class="form-control">
        <option value="enabled">Enabled</option>
        <option value="disabled">Disabled</option>
       </select>
      </div>
     </div>
     <div class="modal-footer">
      <input type="submit" class="btn btn-info" value="Save" />
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
    </form>
   </div>
  </div>
 </div>

<script>
var PUBLICATIONS = <?php echo json_encode($all_publication_names); ?>;
</script>
<script>
$(document).ready(function () {

 PUBLICATIONS.forEach(function (name) {
  $('#projects_publications_list').append($('<option></option>').val(name));
 });

 // One entry per content section. hasImage sections get a file input +
 // "current image" preview handled generically below.
 var sections = {
  banner:   { hasImage: true,  imagePath: '../assets/img/portfolio/1920/', mobileImagePath: '../assets/img/portfolio/mobile/' },
  team:     { hasImage: false },
  projects: { hasImage: true,  imagePath: '../assets/img/portfolio/940/' }
 };

 // --- Projects: repeatable Videos / Reviews rows ---

 function addVideoRow(title, url) {
  var $row = $(
   '<div class="repeat-row">' +
    '<input type="text" name="videos_title[]" class="form-control" placeholder="Label (e.g. Official Trailer)">' +
    '<input type="text" name="videos_url[]" class="form-control" placeholder="YouTube URL">' +
    '<button type="button" class="btn btn-danger btn-xs repeat-row-remove"><i class="glyphicon glyphicon-remove"></i></button>' +
   '</div>'
  );
  $row.find('input').eq(0).val(title || '');
  $row.find('input').eq(1).val(url || '');
  $('#projects_videos_rows').append($row);
 }

 var REVIEW_LOGO_PATH = '../assets/img/review/';

 // Logos are keyed by publication name (server-side, in publication_logos), not by review row:
 // upload one once and it's reused by every review that uses that name, in every project.
 function resolveReviewLogoPreview($row, publication) {
  var $preview = $row.find('.repeat-row-logo-preview');
  publication = (publication || '').trim();
  if (!publication) {
   $preview.hide();
   return;
  }
  $.ajax({
   url: 'projects/publication_logo_lookup.php',
   method: 'POST',
   data: { publication: publication },
   dataType: 'json',
   success: function (res) {
    if (res && res.logo) {
     $preview.attr('src', REVIEW_LOGO_PATH + res.logo).show();
    } else {
     $preview.hide();
    }
   }
  });
 }

 function addReviewRow(publication, url) {
  var $row = $(
   '<div class="repeat-row">' +
    '<input type="text" name="reviews_publication[]" class="form-control repeat-row-publication" placeholder="Publication (e.g. Wikipedia)" list="projects_publications_list">' +
    '<input type="text" name="reviews_url[]" class="form-control" placeholder="Review URL">' +
    '<img class="repeat-row-logo-preview img-thumbnail" src="" alt="">' +
    '<input type="file" class="repeat-row-logo-input" accept=".jpg,.jpeg,.png,.gif,.webp,.svg" title="Upload/replace the logo for this publication name (applies everywhere that name is used)">' +
    '<button type="button" class="btn btn-danger btn-xs repeat-row-remove"><i class="glyphicon glyphicon-remove"></i></button>' +
   '</div>'
  );
  $row.find('.repeat-row-publication').val(publication || '');
  $row.find('input[name="reviews_url[]"]').val(url || '');
  $('#projects_reviews_rows').append($row);
  resolveReviewLogoPreview($row, publication);
 }

 $(document).on('change blur', '.repeat-row-publication', function () {
  resolveReviewLogoPreview($(this).closest('.repeat-row'), $(this).val());
 });

 $(document).on('change', '.repeat-row-logo-input', function () {
  var $row = $(this).closest('.repeat-row');
  var publication = $row.find('.repeat-row-publication').val().trim();
  var file = this.files && this.files[0];
  var $input = $(this);
  if (!file) {
   return;
  }
  if (!publication) {
   alert('Enter the publication name first, then choose a logo.');
   $input.val('');
   return;
  }
  var formData = new FormData();
  formData.append('publication', publication);
  formData.append('logo', file);
  $.ajax({
   url: 'projects/publication_logo_upload.php',
   method: 'POST',
   data: formData,
   processData: false,
   contentType: false,
   dataType: 'json',
   success: function (res) {
    if (res && res.logo) {
     $row.find('.repeat-row-logo-preview').attr('src', REVIEW_LOGO_PATH + res.logo).show();
     if (PUBLICATIONS.indexOf(publication) === -1) {
      PUBLICATIONS.push(publication);
      $('#projects_publications_list').append($('<option></option>').val(publication));
     }
    } else {
     alert((res && res.error) || 'Upload failed.');
    }
    $input.val('');
   },
   error: function () {
    alert('Upload failed.');
    $input.val('');
   }
  });
 });

 $('#projects_add_video').on('click', function () { addVideoRow(); });
 $('#projects_add_review').on('click', function () { addReviewRow(); });
 $(document).on('click', '.repeat-row-remove', function () {
  $(this).closest('.repeat-row').remove();
 });

 function loadTable(section) {
  $.ajax({
   url: section + '/fetch.php',
   method: 'POST',
   success: function (data) {
    $('#' + section + '_table').html(data);
    $('#' + section + '_table tbody').sortable({
     handle: '.drag-handle',
     update: function () {
      var ids = $('#' + section + '_table tbody tr').map(function () {
       return $(this).data('id');
      }).get();
      $.ajax({
       url: section + '/reorder.php',
       method: 'POST',
       data: { ids: ids },
       success: function () {
        $('#' + section + '_table tbody tr td.sr-no').each(function (i) {
         $(this).text(i + 1);
        });
       }
      });
     }
    });
   }
  });
 }

 Object.keys(sections).forEach(loadTable);

 // Open "Add" modal
 $('[data-add]').on('click', function () {
  var section = $(this).data('add');
  $('#' + section + '_form')[0].reset();
  $('#' + section + '_id').val('');
  $('#' + section + '_modal_title').text('Add ' + (section === 'banner' ? 'Slide' : section === 'team' ? 'Member' : 'Project'));
  if (sections[section].hasImage) {
   $('#' + section + '_current_image').hide();
   $('#' + section + '_image').prop('required', true);
   $('#' + section + '_image_required').text('*');
  }
  if (section === 'banner') {
   $('#banner_current_mobile_image').hide();
  }
  if (section === 'projects') {
   $('#projects_videos_rows, #projects_reviews_rows').empty();
  }
  $('#' + section + '_modal').modal('show');
 });

 // Open "Edit" modal
 $(document).on('click', '.edit', function () {
  var $table = $(this).closest('table.table');
  var section = $table.closest('[id$="_table"]').attr('id').replace('_table', '');
  var id = $(this).attr('id');

  $.ajax({
   url: section + '/edit.php',
   method: 'POST',
   data: { id: id },
   dataType: 'json',
   success: function (data) {
    $('#' + section + '_form')[0].reset();
    $('#' + section + '_id').val(id);
    $('#' + section + '_modal_title').text('Edit');

    if (section === 'banner') {
     $('#banner_title').val(data.title);
     $('#banner_category').val(data.category);
     $('#banner_link_url').val(data.link_url);
     $('#banner_status').val(data.status);
     if (data.mobile_image) {
      $('#banner_current_mobile_image').attr('src', sections.banner.mobileImagePath + data.mobile_image).show();
     } else {
      $('#banner_current_mobile_image').hide();
     }
    } else if (section === 'team') {
     $('#team_name').val(data.name);
     $('#team_role').val(data.role);
     $('#team_bio').val(data.bio);
     $('#team_status').val(data.status);
    } else if (section === 'projects') {
     $('#projects_title').val(data.title);
     $('#projects_category').val(data.category);
     $('#projects_link_url').val(data.link_url);
     $('#projects_credits').val(data.credits);
     $('#projects_synopsis').val(data.synopsis);
     $('#projects_status').val(data.status);
     $('#projects_videos_rows, #projects_reviews_rows').empty();
     (data.videos || []).forEach(function (v) { addVideoRow(v.title, v.youtube_url); });
     (data.reviews || []).forEach(function (r) { addReviewRow(r.publication, r.review_url); });
    }

    if (sections[section].hasImage) {
     $('#' + section + '_image').prop('required', false);
     $('#' + section + '_image_required').text('(leave blank to keep current image)');
     $('#' + section + '_current_image').attr('src', sections[section].imagePath + data.image).show();
    }

    $('#' + section + '_modal').modal('show');
   }
  });
 });

 // Submit Add/Edit form
 $('#banner_form, #team_form, #projects_form').on('submit', function (event) {
  event.preventDefault();
  var $form = $(this);
  var section = $form.attr('id').replace('_form', '');
  var id = $('#' + section + '_id').val();
  var url = section + '/' + (id ? 'update.php' : 'create.php');

  var formData = sections[section].hasImage ? new FormData(this) : $form.serialize();

  $.ajax({
   url: url,
   method: 'POST',
   data: formData,
   contentType: sections[section].hasImage ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
   processData: !sections[section].hasImage,
   success: function (data) {
    if ($.trim(data) !== 'success') {
     alert(data);
     return;
    }
    $('#' + section + '_modal').modal('hide');
    loadTable(section);
   },
   error: function () {
    alert('Something went wrong. Please try again.');
   }
  });
 });

 // Toggle enabled/disabled
 $(document).on('click', '.btn-toggle-status', function () {
  var section = $(this).closest('[id$="_table"]').attr('id').replace('_table', '');
  var id = $(this).attr('id');
  var $btn = $(this);

  $.ajax({
   url: section + '/toggle_status.php',
   method: 'POST',
   data: { id: id },
   dataType: 'json',
   success: function (data) {
    if (data.success) {
     if (data.status === 'enabled') {
      $btn.removeClass('btn-default').addClass('btn-success').text('Enabled');
     } else {
      $btn.removeClass('btn-success').addClass('btn-default').text('Disabled');
     }
    }
   }
  });
 });

 // Delete
 $(document).on('click', '.delete', function () {
  var section = $(this).closest('[id$="_table"]').attr('id').replace('_table', '');
  var id = $(this).attr('id');

  if (confirm('Are you sure you want to remove it?')) {
   $.ajax({
    url: section + '/delete.php',
    method: 'POST',
    data: { id: id },
    success: function () {
     loadTable(section);
    }
   });
  }
 });

});
</script>
</body>
</html>
