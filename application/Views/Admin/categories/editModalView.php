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
            <form action="<?php echo $action; ?>" method="POST" class="cat-form edit" enctype="multipart/form-data">
                <div class="modal-body">
                    <? if (isset($category) && isset($category->image)) : ?>
                        <div class="text-center my-3">
                            <img src="<? echo imagesAssets($category->image); ?>" class="rounded img-thumbnail" alt="User avatar" style="width: 400px; height: 400px;">
                        </div>
                    <? endif; ?>
                    <div class="msg"></div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="c-n-e">Category Name</label>
                            <input value="<? echo $category->categoryName ?? '' ?>" name="category_name" type="text" class="form-control" id="c-n-e">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Parent Category</label>
                            <select name="parent_id" id="p-c" class="form-control p-c"></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c-d-n">Description</label>
                        <textarea name="description" style="height: auto;min-height: 100px;text-align: start" class="col-sm-12" id="c-d-n">
                            <? echo $category->desc ?? '' ?>
                        </textarea>
                    </div>
                    <div class="custom-file">
                        <input name="cat_img" type="file" class="custom-file-input" id="customFile-n">
                        <label class="custom-file-label" for="customFile-n">Category Image</label>
                    </div>
                    <div class="mt-2">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input <? echo $category->status == 1 ? 'checked' : null; ?> name="status" value="1" type="checkbox" class="custom-control-input" id="c-s-n">
                                <label class="custom-control-label" for="c-s-n">Status</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-color">Save Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    setParentCategoriesInAddForm(categories);
</script>