<?// pred($post); ?>
<script>
    tinyMCE.remove();
</script>
<form class="save-post" method="post" action="<? echo $action; ?>">
  <div class="msg"></div>
    <? if (isset($post)) : ?>
      <div class="col">
        <img src="<? echo imagesAssets($post->image); ?>" alt="image post" class="img-thumbnail rounded mx-auto d-block mb-5">
      </div>
    <? endif; ?>
    <div class="form-row">
        <div class="form-group col">
            <label for="title-post">Title</label>
            <input value="<? echo isset($post) ? $post->title : null; ?>" name="title" type="text" class="form-control" id="title-post">
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-7 form-group">
            <label for="image-post">Image Post</label>
            <div class="custom-file">
                <input name="image" type="file" class="custom-file-input" id="image-post">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        <div class="col-md-5 form-group">
            <label for="tags">Tags</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="tags" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button id="addTag" class="btn btn-outline-secondary" type="button"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="tags-div" id="tags-div">
                <? if (isset($post->tags)) : $tags = unserialize($post->tags) ?>
                    <? foreach ($tags AS $key => $tag) : ?>
                    <div id="t-<? echo $key; ?>" class="tag d-inline-block">
                      <label for="t-<? echo $key; ?>" class=""><? echo $tag; ?></label>
                      <input name="tags[]" value="<? echo $tag; ?>" hidden id="t-<? echo $key; ?>" type="text">
                      <span class="close-span badge badge-danger"><i class="fas fa-times"></i></span>
                    </div>
                    <? endforeach; ?>
                <? else : ?>
                  <div id="t-1" class="tag d-inline-block">
                    <label for="t-1" class="">example</label>
                    <input hidden id="t-1" type="text">
                    <span class="close-span badge badge-danger"><i class="fas fa-times"></i></span>
                  </div>
                <? endif; ?>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 form-group">
            <label for="categories">Categories</label>
            <select id="categories" name="category" class="custom-select">
                <? foreach ($categories AS $category) : ?>
                    <option value="<? echo $category['id']; ?>" <? echo isset($post) ? ($category['id'] == $post->category_id ? 'selected' : '') : null ?>><? echo $category['categoryName']; ?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label for="posts">Related Posts</label>
            <select id="posts" name="posts[]" class="custom-select" multiple>
                <? foreach ($posts AS $postR) : ?>
                    <option value="<? echo $postR['id']; ?>" <? echo (isset($post) && $related_posts = unserialize($post->related_posts) ) ? (in_array($postR['id'], $related_posts) ? 'selected' : '') : null ?>><? echo $postR['title']; ?></option>
                <? endforeach; ?>
            </select>
        </div>
    </div>
  <div class="form-row">
    <div class="col form-group">
      <label for="editor">Write Post</label>
      <textarea name="editor" id="editor" class="col content"><? echo isset($post) ? htmlspecialchars_decode($post->details) : null ?></textarea>
    </div>
  </div>
    <div class="form-row mt-1">
      <div class="col d-flex justify-content-between">
        <div class="align-self-end">
          <div class="custom-control mb-5 custom-checkbox">
            <input name="status" <? echo isset($post) ? ($post->status == 1 ? 'checked' : 'unchecked') : 'checked'; ?> value="1" type="checkbox" class="custom-control-input" id="status">
            <label class="custom-control-label" for="status">Status</label>
          </div>
          <? if (isset($post)) : ?>
            <div class="mt-3">
              <button class="btn btn-outline-info component" data-url="<? echo $backBTN; ?>">Back</button>
            </div>
          <? endif; ?>
        </div>
        <div class="align-self-end">
          <button type="submit" class="btn bg-color font-500">Save Post</button>
        </div>
      </div>
    </div>
</form>
<script>
    tinymce.init({
        selector:'#editor',
        plugins: "textcolor colorpicker code image",
        toolbar: "undo redo | styleselect | bold italic |  forecolor backcolor | underline code | alignleft aligncenter alignright | image",
        menubar: 'file edit insert view format table tools help',
        image_caption: true,
        image_advtab: true
    });
</script>