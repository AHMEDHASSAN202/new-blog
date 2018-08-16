<!-- Block Header -->
<div class="container-fluid title-page mb-4">
    <div class="text-uppercase text-muted"><?php echo $title ?? ''; ?></div>
</div>
<div class="page-content" id="page_content">
    <div class="container-fluid">
        <div class="card text-muted">
            <div class="header-card">
                <ul class="nav-card andPag activelinks flex-row justify-content-between activelinks">
                    <div class="row">
                        <li class="mx-1 loadByAjax active" data-pagination="users">
                          <a class="p-1" href="<?php echo setLink('admin/pagination/users'); ?>">Users</a>
                        </li>
                        <li class="mx-1 loadByAjax" data-pagination="admins">
                          <a class="p-1" href="<?php echo setLink('admin/pagination/admins'); ?>">Admins</a>
                        </li>
                    </div>
                    <? if (hasPermission('addUser')) : ?>
                      <li class="ml-3 mr-0 hover bg-color" style="margin-top: -7px">
                        <a href="javascript:void(0)" class="btn btn-sm p-2 no-shadow-focus hover-bg modal-load" id="modal" data-url="<?php echo setLink('admin/users/modal/0'); ?>" style="font-weight: 500;">Add User</a>
                      </li>
                    <? endif; ?>
                </ul>
            </div>
            <div class="body-card">
              <!-- search and select inputs  -->
              <div class="row">
                <div class="mb-3 col-md-5">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                    </div>
                    <input data-target="#userBody" data-url="<?php echo setLink('admin/search/users'); ?>" type="text" class="form-control search-input" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                </div>
                <div class="col-md-3 offset-md-4">
                  <div class="input-group">
                    <select class="custom-select" id="pagination" data-target="#userBody" data-url="<?php echo setLink('admin/pagination/'); ?>">
                      <option <?php echo ($pre_page == 10) ? 'selected' : null ; ?> value="10">10</option>
                      <option <?php echo ($pre_page == 20) ? 'selected' : null ; ?> value="20">20</option>
                      <option <?php echo ($pre_page == 50) ? 'selected' : null ; ?> value="50">50</option>
                      <option <?php echo ($pre_page == 70) ? 'selected' : null ; ?> value="70">70</option>
                      <option <?php echo ($pre_page == 100) ? 'selected' : null ; ?> value="100">100</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- #END# search and select inputs -->
              <table class="table table-striped ajaxTable" data-target="#userBody" data-url="<?php echo setLink('admin/pagination/users'); ?>">
                <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Registered Date</th>
                  <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="userBody"></tbody>
              </table>
              <div aria-label="Page navigation example">
                <ul class="pagination justify-content-center"></ul>
              </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# page content -->