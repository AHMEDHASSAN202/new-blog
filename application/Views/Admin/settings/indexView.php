<!-- Block Header -->
<div class="container-fluid title-page mb-4">
    <div class="text-uppercase text-muted"><?php echo $title ?? ''; ?></div>
</div>
<div class="page-content" id="page_content">
    <div class="container-fluid">
        <div class="card text-muted">
            <div class="header-card">
                <ul class="nav-card flex-row justify-content-between activelinks">
                    <div class="row">
                        <li class="mx-1 active">
                            <span class="p-1 cursor-pointer">Settings</span>
                        </li>
                    </div>
                </ul>
            </div>
            <div class="body-card position-relative" id="body-card">
                <div class="msg"></div>
                <div class="gif-loading">
                    <img src="<? echo adminAssets('images/icons/loader-db80c58.gif'); ?>">
                </div>
                <form method="post" action="<? echo $actionForm; ?>" id="settings">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="siteName">Site name</label>
                            <input name="name" type="text" class="form-control" id="siteName" value="<? echo isset($settings['site_name']) ? $settings['site_name'] : null ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="emailSite">Site Email</label>
                            <input name="email" type="email" class="form-control" id="emailSite" value="<? echo isset($settings['site_email']) ? $settings['site_email'] : null ?>">
                        </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="form-group col-md-6">
                        <label for="copyRight">Copy Right</label>
                        <input name="copyright" type="text" class="form-control" id="copyRight" value="<? echo isset($settings['site_copyright']) ? $settings['site_copyright'] : null ?>">
                      </div>
                      <div class="form-group col-md-6">
                          <label for="s_c_m">Site Close Message</label>
                          <input name="siteCloseMsg" type="text" class="form-control" id="s_c_m"  value="<? echo isset($settings['site_close_msg']) ? $settings['site_close_msg'] : null ?>">
                      </div>
                    </div>
                    <div class="form-row mt-3">
                      <div class="col-md-6">
                        <div class="custom-control custom-checkbox mr-sm-2" style="margin-top: 10px">
                          <input name="status" value="1" type="checkbox" class="custom-control-input" id="customControlInline" <? echo (isset($settings['site_status']) && $settings['site_status'] == 1) ? 'checked' : null;  ?>>
                          <label class="custom-control-label" for="customControlInline">Site Status</label>
                        </div>
                      </div>
                      <div class="form-group col-md-6">
                        <div class="custom-file">
                          <label class="custom-file-label" for="customFile">Choose Site Logo</label>
                          <input name="logo" type="file" class="custom-file-input" id="customFile" value="<? echo isset($settings['site_logo']) ? $settings['site_logo'] : null ?>">
                        </div>
                      </div>
                    </div>
                    <? if (hasPermission('editSettings')) : ?>
                      <button type="submit" class="btn bg-color mt-5">Save</button>
                    <? endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- #END# page content -->