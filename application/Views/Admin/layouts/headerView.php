<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="angular dashboard">
    <meta name="keywords" content="admin panel, angular, angular dashboard, dashboard">
    <meta name="author" content="ahmed hassan">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angular Dashboard</title>
    <link rel="icon" href="<?php echo adminAssets('images/icons/admin.ico'); ?>">
    <link rel="stylesheet" href="<?php echo pluginsAssets('bootstrap-4.0.0/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo pluginsAssets('fontawesome-free-5.1.0-web/css/all.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo adminAssets('css/style.css'); ?>">
    <?php if(!empty($css)) : ?>
      <?php foreach($css AS $cssFile): ?>
        <link rel="stylesheet" href="<?php echo $cssFile; ?>">
      <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
<div class="wrapper" id="wrapper">
    <?php // echo $sidebar; ?>
    <!-- Content Wrapper -->
    <div class="wrapper-content">
        <!-- Navbar -->
        <nav class="col-md-9 mx-auto" id="nav">
            <ul class="navbar m-0 justify-content-between">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="bars" id="bars"></a>
                </li>
                <li class="nav-item">
                    <ul class="nav m-0">
                        <li class="nav-item">
                            <a class="nav-link m-1 p-2 hover active" href="<?php echo setLink('admin/dashboard'); ?>">
                                <i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link hover m-1 p-2 modal-load" href="javascript:void(0)" data-url="<?php echo setLink('admin/profile'); ?>">
                                <i class="fas fa-user-alt"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link hover m-1 p-2" href="<?php echo setLink(''); ?>">
                            <i class="fas fa-eye"></i>
                            <span>View Website</span>
                          </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link hover m-1 p-2" href="<?php echo setLink('admin/settings'); ?>">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo setLink('admin/logout'); ?>" class="nav-link hover">
                        <i class="fas fa-power-off"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- #END# Navbar -->
      <!-- Delete user Modal -->
      <div style="z-index: 9999" class="modal" id="delete-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="msg"></div>
            <div class="modal-body">
              <p>you sure about that ? </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary delete-ok">Yes</button>
            </div>
          </div>
        </div>
      </div>
      <!--#END# Delete user Modal -->