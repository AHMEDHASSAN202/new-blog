<script>
    function tableCat(categoires) {
        var table = '';
        for (var i = 0; i < categoires.length; i++) {
            parent_cat =  typeof categoires[i].parent_cat === 'undefined' ? '....' : categoires[i].parent_cat;
            editBTN = (categoires[i].edit == false) ? 'hidden' : null;
            deleteBTN = (categoires[i].delete == false) ? 'hidden' : null;
            table += '<tr>' +
                  '<th scope="row">'+ (i+1) +'</th>' +
                  '<td>'+ categoires[i].categoryName +'</td>' +
                  '<td>'+ parent_cat +'</td>'+
                  '<td>'+
                    '<button '+ editBTN +' data-url="'+ categoires[i].edit +'" class="btn btn-outline-primary modal-load btn-action mr-1" title="edit"><i class="fas fa-user-edit"></i></button>'+
                    '<button '+ deleteBTN +' data-url="'+ categoires[i].delete +'" type="button" class="btn btn-outline-danger btn-action deleteCat ml-1" title="delete"><i class="fas fa-trash-alt"></i></button>'
                  +'</td>'+
                '</tr>';
        }
        return table;
    }
    var categories = <?php echo json_encode($categories); ?>;
    function parentCategoriesOptions(categories) {
        var options = '<option value="0">Main Category</option>'
        for (var i = 0; i < categories.length; i++) {
            if (categories[i].parent_id == 0) {
                options += '<option value="'+ categories[i].id +'">'+ categories[i].categoryName +'</option>';
            }
        }
        return options;
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
            <div class="col">
                <div class="card text-muted">
                    <div class="header-card">
                        Add Categories
                    </div>
                    <div class="body-card">
                        <? if (hasPermission('addCategories')) : ?>
                          <form class="cat-form" method="post" action="<?php echo $action; ?>" enctype="multipart/form-data">
                            <div class="msg"></div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="c-n">Category Name</label>
                                <input name="category_name" type="text" class="form-control" id="c-n">
                              </div>
                              <div class="form-group col-md-6">
                                <label for="p-c">Parent Category</label>
                                <select name="parent_id" id="p-c" class="form-control p-c"></select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="c-d">Description</label>
                              <textarea name="description" style="height: auto;min-height: 100px;" class="col-sm-12" id="c-d"></textarea>
                            </div>
                            <div class="custom-file">
                              <input name="cat_img" type="file" class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Category Image</label>
                            </div>
                            <div class="mt-2">
                              <div class="form-group">
                                <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                  <input name="status" value="1" checked type="checkbox" class="custom-control-input" id="c-s">
                                  <label class="custom-control-label" for="c-s">Status</label>
                                </div>
                              </div>
                              <div>
                                <button type="submit" class="btn bg-color float-right">Add</button>
                              </div>
                            </div>
                          </form>
                        <? else : ?>
                          <div class="text-center text-warning">
                            <span>need to permission</span>
                          </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <div class="col cat-list">
                <div class="card text-muted">
                    <div class="header-card">
                        Categories
                    </div>
                    <div class="card-body col-sm-12 px-0">
                        <table class="table table-responsive-sm table-cat">
                            <div class="msg-t"></div>
                            <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Parent</th>
                                  <th scope="col">actions</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>