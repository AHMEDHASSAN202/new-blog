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
                            <span class="p-1 cursor-pointer">Messages</span>
                        </li>
                    </div>
                </ul>
            </div>
            <div class="body-card position-relative" id="body-card">
                <div class="msg"></div>
                <div class="gif-loading">
                    <img src="<? echo adminAssets('images/icons/loader-db80c58.gif'); ?>">
                </div>
              <table class="table table-striped">
                <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Subject</th>
                  <th scope="col" style="width: 250px;">Message</th>
                  <th scope="col">Created</th>
                  <th scope="col">actions</th>
                </tr>
                </thead>
                <tbody id="messages"></tbody>
              </table>
            </div>
        </div>
    </div>
</div>
<!-- #END# page content -->

<script>
  messages = <? echo json_encode($messages); ?>;
  function messagesTable(messages)
  {
      body = '';
      if (messages.length) {
          for (var i=0; i<messages.length; i++) {
              tr = '<tr>'
              tr += '<td>'+ (i+1) +'</td>'
              tr += '<td>'+ messages[i].name +'</td>'
              tr += '<td>'+ messages[i].email +'</td>'
              tr += '<td>'+ messages[i].subject +'</td>'
              tr += '<td>'+ messages[i].message +'</td>'
              tr += '<td>'+ messages[i].created +'</td>'
              tr += '<td>'
              if (messages[i].view != false) {
                  tr += '<button type="button" title="view"  data-url="'+ messages[i].view +'" class="btn btn-outline-info viewMsg"><i class="fas fa-eye"></i></button>\n'
              }
              if (messages[i].reply != false) {
                  tr += '<button type="button" title="reply"  data-url="'+ messages[i].view + '?reply=true' +'" class="btn btn-outline-primary viewMsg"><i class="fas fa-reply"></i></button>\n'
              }
              if (messages[i].delete != false) {
                  tr += '<button type="button" title="delete" data-url="'+ messages[i].delete +'" class="btn btn-outline-danger deleteMsg"><i class="fas fa-trash-alt"></i></button>'
              }
              tr += '</td>'
              tr += '</tr>'
              body += tr;
          }
      } else {
          body += '<div class="text-muted text-center my-3">no messages</div>';
      }
      document.getElementById('messages').innerHTML = body;
  }
  messagesTable(messages);
</script>