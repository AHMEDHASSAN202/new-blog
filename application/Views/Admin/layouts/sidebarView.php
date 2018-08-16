<!-- Sidebar -->
<div class="sidebar-l bg-white text-muted border-color">
    <div class="user-information">
        <div class="box-user">
            <img src="<?php echo $user->image ? imagesAssets($user->image) : imagesAssets('users/default avatar.png');  ?>" alt="your image">
            <div class="info mt-3">
                <div class="font-weight-bold text-capitalize"><?php echo ucwords($user->first_name . ' ' . $user->last_name); ?></div>
                <div class="mr-3">
                    <p><?php echo $user->email; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-sidebar">
        <div class="title">main navigation</div>
        <div class="menu">
            <ul class="text-muted m-0 p-0 pt-2">
                <?php foreach ($pages As $page) : ?>
                  <li>
                    <a href="<?php echo $page['url']; ?>" class="hover">
                      <span class="<?php echo $page['iconClass'];  ?>"></span>
                      <span class="ml-1"><?php echo ucwords($page['name']); ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<!-- #END# sidebar -->