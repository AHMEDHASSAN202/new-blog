<!-- Modal -->
<div class="modal fade" id="modalSection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $titleModal; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <form action="<?php echo $actionForm; ?>" method="POST" class="saveByAjax" enctype="multipart/form-data">
            <div class="msg"></div>
            <div class="modal-body">
              <? if (isset($user) && isset($user->image)) : ?>
                <div class="text-center my-3">
                  <img src="<? echo imagesAssets($user->image); ?>" class="rounded img-thumbnail" alt="User avatar" style="width: 400px; height: 400px;">
                </div>
              <? endif; ?>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input value="<? echo $user->first_name ?? ''; ?>" name="first_name" type="text" class="form-control" id="first_name">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input value="<? echo $user->last_name ?? ''; ?>" name="last_name" type="text" class="form-control" id="last_name">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input value="<? echo $user->email ?? ''; ?>" name="email" type="email" class="form-control" id="inputEmail4">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4"><? echo $passwordName ?? 'Password' ?></label>
                    <input name="password" type="password" class="form-control" id="inputPassword4">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control">
                      <? if (!isset($user->gender)) : ?>
                        <option value="false" selected>Choose...</option>
                      <? endif; ?>
                      <option <? echo (isset($user->gender) && $user->gender == 1) ? 'selected' : ''; ?> value="1">Male</option>
                      <option <? echo (isset($user->gender) && $user->gender == 0) ? 'selected' : ''; ?> value="0">Female</option>
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="usersGroup">Users Group</label>
                    <select name="users_group" id="usersGroup" class="form-control">
                      <? if (!isset($user->users_group_id)): ?>
                        <option value="false" selected>Choose...</option>
                      <? endif; ?>
                      <?php if ($usersGroups) : ?>
                          <?php foreach ($usersGroups AS $group) : ?>
                          <option <? echo (isset($user->users_group_id) && ($group->id === $user->users_group_id)) ? 'selected' : ''; ?> value="<?php echo $group->id; ?>"><?php echo $group->permission; ?></option>
                          <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="image"><? echo $imageName ?? 'Image'; ?></label>
                    <input value="<? echo $user->image ?? '';  ?>" name="image" type="file" id="image" style="height: 37px;" class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="birthday">birthday</label>
                    <input value="<? echo $user->birthday ?? '' ?>" name="birthday" type="date" id="birthday" class="form-control">
                  </div>
                </div>
                <? if (isset($deleteProfile)) : ?>
                  <div class="form-row mt-2">
                    <div class="form-group col">
                      <a class="text-danger font-500 delete-btn" href="" data-url="<? echo $deleteProfile; ?>" data-target="#delete-modal">
                        <span class="far fa-times-circle d-inline-block"></span>
                        Delete Your Profile
                      </a>
                    </div>
                  </div>
                <? endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><?php echo isset($user) ? 'Save Data' : 'Add New User'?></button>
            </div>
          </form>
        </div>
    </div>
</div>