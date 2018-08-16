<script>
  var groups = <? echo json_encode($groups); ?>

  function putGroupsInTable(groups)
  {
      var body = '';
      for (var i=0; i<groups.length; i++)  {
          user = groups[i].id == 0 ? true : false;
          body += '<tr style="height: 58px">';
          body += '<th>'+ (i+1) +'</th>';
          body += '<td>'+ groups[i].permission +'</td>';
          if (!user) {
              editBTN = (groups[i].edit) == false ? 'hidden' : null ;
              deleteBTN = (groups[i].delete) == false ? 'hidden' : null;
              body += '<td>' +
                  '<button '+ editBTN +' data-target="'+ groups[i].get +'" data-url="'+ groups[i].edit +'" class="btn btn-outline-primary mx-1 edit-role" title="edit"><i class="fas fa-user-edit"></i></button>' +
                  '<button '+ deleteBTN +' data-url="'+ groups[i].delete +'" class="btn btn-outline-danger mx-1 delete-role" title="delete"><i class="fas fa-trash-alt"></i></button>' +
                  '</td>';
          }
          body += '</tr>'
      }
      return body;
  }
</script>
<!-- Block Header -->
<div class="container-fluid title-page mb-4">
    <div class="text-uppercase text-muted"><?php echo $title ?? ''; ?></div>
</div>
<!-- #END# Block Header -->
<div class="page-content" id="page_content">
    <div class="container-fluid">
        <div class="row extend-section">
            <div class="col-md-7 col-sm-12">
                <div class="card text-muted">
                    <div class="header-card">
                        Add Group
                    </div>
                    <div class="body-card">
                      <? if (hasPermission('addRoles')) : ?>
                        <form class="role-save" method="post" action="<?php echo $action; ?>" data-target="<?php echo $action; ?>">
                          <div class="msg"></div>
                          <div class="form-group">
                            <label for="group-name">Group Name</label>
                            <input name="groupName" type="text" class="form-control" id="group-name">
                          </div>
                          <div class="text-muted title-page pb-2">Permissions</div>
                          <div class="row roles-div">
                            <div class="col">
                              <ul class="p-0 m-0">
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[userPage]" value="<? echo setLink('admin/users'); ?>" type="checkbox" class="custom-control-input parent-checkbox" id="userPage">
                                    <label class="custom-control-label" for="userPage">Users Page</label>
                                  </div>
                                  <input class="invisible position-absolute" name="roles[userGet]" value="<? echo setLink('admin/users/get'); ?>" type="checkbox" for="userPage">
                                  <input class="invisible position-absolute" name="roles[userModal]" value="<? echo setLink('admin/users/modal/:id'); ?>" type="checkbox" for="userPage">
                                  <input class="invisible position-absolute" name="roles[adminsGet]" value="<? echo setLink('admin/admins/get'); ?>" type="checkbox" for="userPage">
                                  <input class="invisible position-absolute" name="roles[userSearch]" value="<? echo setLink('admin/search/users'); ?>" type="checkbox" for="userPage">
                                  <input class="invisible position-absolute" name="roles[userPagination]" value="<? echo setLink('admin/pagination/:text'); ?>" type="checkbox" for="userPage">
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[addUser]" value="<? echo setLink('admin/users/add'); ?>" disabled type="checkbox" class="custom-control-input" id="addUser">
                                    <label class="custom-control-label" for="addUser">add</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[editUser]" value="<? echo setLink('admin/users/edit/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="editUser">
                                    <label class="custom-control-label" for="editUser">edit</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[deleteUser]" value="<? echo setLink('admin/users/delete/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="deleteUser">
                                    <label class="custom-control-label" for="deleteUser">delete</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[viewUser]" value="<? echo setLink('admin/users/view/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="viewUser">
                                    <label class="custom-control-label" for="viewUser">view</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="col">
                              <ul class="p-0 m-0">
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[rolesPage]" value="<? echo setLink('admin/roles'); ?>" type="checkbox" class="custom-control-input" id="rolesPage">
                                    <label class="font-500 custom-control-label" for="rolesPage">Roles Page</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[addRoles]" value="<? echo setLink('admin/roles/save/0'); ?>" disabled type="checkbox" class="custom-control-input" id="addRoles">
                                    <label class="custom-control-label" for="addRoles">add</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[editRoles]" value="<? echo setLink('admin/roles/save/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="editRoles">
                                    <label class="custom-control-label" for="editRoles">edit</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[deleteRoles]" value="<? echo setLink('admin/roles/delete/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="deleteRoles">
                                    <label class="custom-control-label" for="deleteRoles">delete</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[viewRoles]" value="<? echo setLink('admin/roles/get/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="viewRoles">
                                    <label class="custom-control-label" for="viewRoles">view</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="col">
                              <ul class="p-0 m-0">
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[categoriesPage]" value="<? echo setLink('admin/categories'); ?>" type="checkbox" class="custom-control-input" id="categoriesPage">
                                    <label class="font-500 custom-control-label" for="categoriesPage">Categories Page</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[addCategories]" value="<? echo setLink('admin/categories/save'); ?>" disabled type="checkbox" class="custom-control-input" id="addCategories">
                                    <label class="custom-control-label" for="addCategories">add</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[editCategories]" value="<? echo setLink('admin/categories/edit/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="editCategories">
                                    <label class="custom-control-label" for="editCategories">edit</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[deleteCategories]" value="<? echo setLink('admin/categories/delete/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="deleteCategories">
                                    <label class="custom-control-label" for="deleteCategories">delete</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="row roles-div mt-3">
                            <div class="col">
                              <ul class="p-0 m-0">
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[postsPage]" value="<? echo setLink('admin/posts'); ?>" type="checkbox" class="custom-control-input" id="postsPage">
                                    <label class="font-500 custom-control-label" for="postsPage">Posts Page</label>
                                  </div>
                                  <input class="invisible position-absolute" name="roles[postsSearch]" value="<? echo setLink('admin/search/posts'); ?>" type="checkbox" for="postsPage">
                                  <input class="invisible position-absolute" name="roles[postsLoad]" value="<? echo setLink('admin/posts/load/:text/:id'); ?>" type="checkbox" for="postsPage">
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[addPosts]" value="<? echo setLink('admin/posts/add'); ?>" disabled type="checkbox" class="custom-control-input" id="addPosts">
                                    <label class="custom-control-label" for="addPosts">add</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[editPosts]" value="<? echo setLink('admin/posts/edit/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="editPosts">
                                    <label class="custom-control-label" for="editPosts">edit</label>
                                  </div>
                                </li>
                                <li>
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[deletePosts]" value="<? echo setLink('admin/posts/delete/:id'); ?>" disabled type="checkbox" class="custom-control-input" id="deletePosts">
                                    <label class="custom-control-label" for="deletePosts">delete</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="col">
                              <ul class="p-0 m-0">
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[messagesPage]" value="<? echo setLink('admin/messages'); ?>" type="checkbox" class="custom-control-input" id="messagesPage">
                                    <label class="font-500 custom-control-label" for="messagesPage">Messages Page</label>
                                  </div>
                                </li>
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[replyMessages]" value="<? echo setLink('admin/messages/reply/:id'); ?>" type="checkbox" class="custom-control-input" id="replyMessages">
                                    <label class="font-500 custom-control-label" for="replyMessages">reply</label>
                                  </div>
                                </li>
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[deleteMessages]" value="<? echo setLink('admin/messages/delete/:id'); ?>" type="checkbox" class="custom-control-input" id="deleteMessages">
                                    <label class="font-500 custom-control-label" for="deleteMessages">delete</label>
                                  </div>
                                </li>
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[viewMessages]" value="<? echo setLink('admin/messages/view/:id'); ?>" type="checkbox" class="custom-control-input" id="viewMessages">
                                    <label class="font-500 custom-control-label" for="viewMessages">view</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="col">
                              <ul class="p-0 m-0">
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[settingsPage]" value="<? echo setLink('admin/settings'); ?>" type="checkbox" class="custom-control-input" id="settingsPage">
                                    <label class="font-500 custom-control-label" for="settingsPage">Settings Page</label>
                                  </div>
                                </li>
                                <li class="mb-1">
                                  <div class="custom-control custom-checkbox">
                                    <input name="roles[editSettings]" value="<? echo setLink('admin/settings/save'); ?>" type="checkbox" class="custom-control-input" id="editSettings">
                                    <label class="font-500 custom-control-label" for="editSettings">edit</label>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="row justify-content-between mt-5">
                            <div class="col-md-3">
                              <button type="submit" class="btn bg-color px-4">Add</button>
                            </div>
                            <div class="col-md-2">
                              <button type="button" onclick="resetForm()" class="btn btn-info px-2">Reset</button>
                            </div>
                          </div>
                        </form>
                      <? else: ?>
                      <div class="text-center">
                        <span class="text-warning font-weight-light">need to permission</span>
                      </div>
                      <? endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 cat-list">
                <div class="card text-muted">
                    <div class="header-card">
                        Groups
                    </div>
                    <div class="card-body col-sm-12 px-0 table-role">
                      <? if (hasPermission('viewRoles')) : ?>
                        <table class="table table-responsive-sm">
                            <div class="msg-t"></div>
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">actions</th>
                            </tr>
                            </thead>
                            <tbody class="body-roles"></tbody>
                        </table>
                      <? else: ?>
                        <div class="text-center">
                          <span class="text-warning font-weight-light">need to permission</span>
                        </div>
                      <? endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>