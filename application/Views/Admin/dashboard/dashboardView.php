<!-- Block Header -->
<div class="container-fluid title-page mb-4">
    <div class="text-uppercase text-muted"><?php echo $title; ?></div>
</div>
<!-- #END# Block Header -->
<!-- BreadCrumb -->
<!--<div class="container-fluid">-->
<!--    <nav class="bread" aria-label="breadcrumb">-->
<!--        <ol class="breadcrumb">-->
<!--            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>-->
<!--        </ol>-->
<!--    </nav>-->
<!--</div>-->
<!-- #END# BreadCrumb -->
<!--- Page Content -->
<div class="page-content" id="page_content">
    <div class="container-fluid">
        <div class="boxes px-0 row" id="boxes">
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <div class="d-flex">
                    <div class="icon-box text-center">
                        <span class="fas fa-users fa-3x"></span>
                    </div>
                    <div class="box">
                        <div class="name">Users</div>
                        <div class="count"><?php echo $countUsers; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <div class="d-flex">
                    <div class="icon-box text-center">
                        <span class="fas fa-pen fa-3x"></span>
                    </div>
                    <div class="box">
                        <div class="name">Posts</div>
                        <div class="count"><?php echo $countPosts; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <div class="d-flex">
                    <div class="icon-box text-center">
                        <span class="fas fa-comments fa-3x"></span>
                    </div>
                    <div class="box">
                        <div class="name">Comments</div>
                        <div class="count"><?php echo $countComments; ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12 mb-3">
                <div class="d-flex">
                    <div class="icon-box text-center">
                        <span class="fas fa-comment-alt fa-3x"></span>
                    </div>
                    <div class="box">
                        <div class="name">Messages</div>
                        <div class="count"><?php echo $countMessages; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card text-muted">
            <div class="header-card">The latest users</div>
            <div class="body-card">
              <table class="table">
                <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Registered Date</th>
                  <th scope="col">View</th>
                </tr>
                </thead>
                <? if (hasPermission('postsPage')) : ?>
                  <tbody>
                  <?php foreach ($users as $key => $user) : ?>
                    <tr>
                      <th scope="row"><?php echo $key+1; ?></th>
                      <td><?php echo ucwords($user->name); ?></td>
                      <td><?php echo $user->email; ?></td>
                      <td><?php echo $user->createdDate; ?></td>
                      <td>
                          <? if(hasPermission('viewUser')) : ?>
                            <a class="inherit-bootstrap view-btn" href="javascript:void(0)" data-url="<?php echo setLink('admin/users/view/'.$user->userID); ?>">view profile</a>
                          <? else: ?>
                            <div class="text-warning font-weight-light" style="cursor: default">need to permission</div>
                          <? endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                <? else : ?>
                  <? $permissionPosts = false; ?>
                <? endif; ?>
              </table>
                <? if (isset($permissionPosts) && $permissionPosts === false) : ?>
                  <div class="text-center text-warning">you need to permissions</div>
                <? endif; ?>
            </div>
        </div>
      <div class="card text-muted">
        <div class="header-card">The latest Messages</div>
        <div class="body-card">
          <table class="table">
            <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Email</th>
              <th scope="col">Subject</th>
              <th scope="col">Message</th>
              <th scope="col">Created</th>
              <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
              <? if (hasPermission('messagesPage')) : ?>
                  <?php foreach ($messages as $key => $message) : ?>
                  <tr>
                    <th scope="row"><?php echo $key+1; ?></th>
                    <td><?php echo $message['email']; ?></td>
                    <td><?php echo $message['subject']; ?></td>
                    <td><?php echo $message['message']; ?></td>
                    <td><?php echo $message['created']; ?></td>
                    <td>
                      <? if($message['view'] != false) : ?>
                        <button type="button" title="view"  data-url=<? echo $message['view'] ?> class="btn btn-outline-info viewMsg"><i class="fas fa-eye"></i></button>
                      <? endif; ?>
                      <? if ($message['reply'] != false) : ?>
                        <button type="button" title="reply"  data-url=<? echo $message['view'] . '?reply=true'; ?> class="btn btn-outline-primary viewMsg"><i class="fas fa-reply"></i></button>
                      <? endif; ?>
                      <? if ($message['delete'] != false) : ?>
                      <button type="button" title="delete" data-url=<? echo $message['delete'] ?> class="btn btn-outline-danger deleteMsg"><i class="fas fa-trash-alt"></i></button>
                      <? endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
              <? else: ?>
                <? $permissionMessages = false; ?>
              <? endif;?>
            </tbody>
          </table>
          <? if (isset($permissionMessages) && $permissionMessages === false) : ?>
            <div class="text-center text-warning">you need to permissions</div>
          <? endif; ?>
        </div>
      </div>
    </div>
</div>
<!-- #END# page content -->