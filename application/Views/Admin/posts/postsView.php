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
                            <span class="p-1 cursor-pointer">Posts</span>
                        </li>
                    </div>
                    <? if (hasPermission('addPosts')) : ?>
                      <li class="ml-3 mr-0 hover bg-color" style="margin-top: -7px">
                        <a data-target="<? echo $viewLink ?>" href="<? echo $addLink ?>" class="btn btn-sm p-2 no-shadow-focus hover-bg load-component" style="font-weight: 500;">
                          <span class="text">Add Post</span>
                          <span class="bars-section"></span>
                        </a>
                      </li>
                   <? endif; ?>
                </ul>
            </div>
            <div class="body-card position-relative" id="body-card">
              <div class="msg"></div>
              <div class="gif-loading">
                <img src="<? echo adminAssets('images/icons/loader-db80c58.gif'); ?>">
              </div>
              <? echo $postsView; ?>
            </div>
        </div>
    </div>
</div>
<!-- #END# page content -->