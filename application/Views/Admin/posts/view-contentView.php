

<!-- search and select inputs  -->
<div class="row">
  <div class="mb-3 col-md-5">
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
      </div>
      <input data-target="#posts" data-url="<? echo $searchUrl; ?>" type="text" class="form-control search-input" placeholder="search" aria-label="Username" aria-describedby="basic-addon1">
    </div>
  </div>
  <div class="col-md-3 offset-md-4">
    <div class="input-group">
      <select class="custom-select" id="pagination-post" data-target="<? echo $paginationUrl; ?>">
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
<table class="table table-striped">
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Category</th>
    <th scope="col">Created by</th>
    <th scope="col" style="width: 250px;">Title</th>
    <th scope="col">Views</th>
    <th scope="col">Status</th>
    <th scope="col">actions</th>
  </tr>
  </thead>
  <tbody id="posts"></tbody>
</table>
<div aria-label="Page navigation example">
  <ul class="pagination justify-content-center" id="pagination"></ul>
</div>

<script>
    var posts = <? echo json_encode($posts) ?>;
    console.log(posts);
    function preparePostsTable(posts) {
        body = '';
        for (var i=0; i<posts.length; i++) {
            status = (posts[i].status == 1) ? 'Enabled' : '<span class="text-danger">Disabled</span>';
            tr = '<tr>'
            tr += '<td>'+ (i+1) +'</td>'
            tr += '<td>'+ posts[i].category +'</td>'
            tr += '<td>'+ posts[i].username +'</td>'
            tr += '<td>'+ posts[i].title +'</td>'
            tr += '<td>'+ posts[i].views +'</td>'
            tr += '<td>'+ status +'</td>'
            tr += '<td>'
            tr += '<button type="button" title="view" data-url="'+ posts[i].view +'" class="btn btn-outline-info component"><i class="fas fa-eye"></i></button>\n'
            if (posts[i].edit != false) {
                tr += '<button type="button" title="edit" data-url="'+ posts[i].edit +'" class="btn btn-outline-primary component"><i class="fas fa-user-edit"></i></button>\n'
            }
            if (posts[i].delete != false) {
                tr += '<button type="button" title="delete" data-url="'+ posts[i].delete +'" class="btn btn-outline-danger deletePost"><i class="fas fa-trash-alt"></i></button>'
            }
            tr += '</td>'
            tr += '</tr>'
            body += tr;
        }
        document.getElementById('posts').innerHTML = body;

    }
    preparePostsTable(posts);

    function createPaginationButtons(count_pages, current_page)
    {
        ul = '';
        for (var i = 1; i <= count_pages; i++) {
            activeClass = (i == current_page) ? 'active' : '';
            ul += '<li onclick="ajaxPagination(event)" class="btn-pagination '+ activeClass +'"><a data-target="'+ i +'" class="page-link">'+ i +'</a></li>'
        }
        ulPagination = document.getElementById('pagination');
        ulPagination.innerHTML = ul;
    }
    var count_pages = <? echo $count_pages ?>;
    var paginationUrl = <? echo json_encode($paginationUrl) ?>;
    var currentPage = <? echo $current_page ?>;
    createPaginationButtons(count_pages, currentPage)
</script>