<div class="container-fluid">
    <div>
        <h2 class="display-5"><? echo $post->title; ?></h2>
    </div>
    <div class="my-4">
        <img src="<? echo isset($post->image) ? imagesAssets($post->image) : null; ?>" class="img-fluid" alt="Responsive image">
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="mt-3">
                <? echo htmlspecialchars_decode($post->details); ?>
            </div>
            <div class="mt-2">
                <div class="mb-4">
                    <div>Tags</div>
                    <? if (isset($post->tags)) : $tags = unserialize($post->tags); ?>
                        <? foreach ($tags AS $tag) : ?>
                            <a href="#">
                                <div class="tags-div">
                                    <div class="tag">
                                        <label class="font-500 cursor-pointer"><? echo $tag; ?></label>
                                    </div>
                                </div>
                            </a>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
                <div class="row">
                    <p class="col">Created by : <span class="color"><? echo $post->username; ?></span></p>
                    <p class="col text-muted">Created at : <? echo isset($post->created) ? date('Y-m-d h-i a', $post->created) : null; ?></p>
                </div>
            </div>
            <div class="mt-4">
              <h5 class="font-weight-normal mb-3">Comments</h5>
                <? if (isset($post->comments) && !empty($post->comments)) : ?>
                    <? foreach ($post->comments AS $key => $comment) : ?>
                    <div class="ml-2">
                      <div class="media mb-2">
                        <img class="mr-3" style="width: 65px; height: 65px;" src="<? echo imagesAssets($comment['image']); ?>" alt="Generic placeholder image">
                        <div class="media-body">
                          <h5 class="mt-0 mb-1"><? echo $comment['username']; ?></h5>
                            <? echo $comment['comment']; ?>
                          <small class="d-block text-muted"><? echo diff_date($comment['created']) . ' ago'; ?></small>
                        </div>
                      </div>
                    </div>
                    <? endforeach; ?>
                <? else : ?>
                  <small class="text-muted ml-3">no comments</small>
                <? endif; ?>
            </div>
            <div class="mt-5">
                <button class="btn btn-outline-info component" data-url="<? echo $backBTN; ?>">Back</button>
            </div>
        </div>
        <div class="col-md-4">
            <h4 class="text-muted font-weight-normal mb-3">Related Posts</h4>
            <div class="list-group">
                <? if (isset($post->related_posts) && !empty($post->related_posts)) :  ?>
                    <? foreach ($post->related_posts as $r_post) : ?>
                        <a href="javascript:void(0)" data-url="<? echo setLink('admin/posts/load/view/'.$r_post['id']); ?>" class="list-group-item list-group-item-action flex-column align-items-start component">
                            <div class="d-flex justify-content-between">
                                <div class="w-100">
                                    <h5 class="mb-1 font-weight-normal"><? echo $r_post['title']; ?></h5>
                                    <small><? echo diff_date($r_post['created']); ?></small>
                                </div>
                                <div>
                                    <img src="<? echo imagesAssets($r_post['image']) ?>" alt="post image" style="height: 50px; width: 50px;">
                                </div>
                            </div>
                        </a>
                    <? endforeach; ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>