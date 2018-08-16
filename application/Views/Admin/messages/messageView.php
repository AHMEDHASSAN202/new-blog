<!-- View Modal -->
<div class="modal fade" id="viewMsg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><? echo $title; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reply_msg" method="post" <? echo ($action == 'reply' && isset($actionForm)) ?'action="'. $actionForm .'"' : '' ?>>
                <div class="modal-body">
                    <div class="msg"></div>
                    <div class="col bg-light p-3">
                        <div class="d-flex justify-content-between">
                            <strong class="align-self-start font-500">Email : <? echo $message['email']; ?></strong>
                            <small class="align-self-end">Name : <? echo $message['name']; ?></small>
                        </div>
                        <div class="mt-5">
                            <h4 class="font-weight-normal mb-0"><? echo $message['subject']; ?></h4>
                            <div><? echo $message['message']; ?></div>
                        </div>
                        <div class="d-flex justify-content-between my-5">
                            <small class="align-self-start">Sent : <? echo diff_date($message['created']) . ' ago'; ?></small>
                            <small class="align-self-end">Phone: <? echo $message['phone']; ?></small>
                        </div>
                    </div>
                    <? if (isset($message['reply'])) : ?>
                        <div class="form-group mt-3">
                            <label for="message-text" class="col-form-label"><strong>Reply</strong></label>
                            <textarea name="reply" <? echo $action == 'view' ? 'disabled' : '';  ?> class="form-control" id="message-text"><? echo $message['reply']; ?></textarea>
                        </div>
                        <? if ($message['reply'] != '') : ?>
                            <div class="d-flex justify-content-between mt-0 mb-3">
                                <small class="align-self-start font-weight-bold">Replied by : <? echo ucwords($message['replied_by']) ; ?></small>
                                <small class="align-self-end">Replied at: <? echo diff_date($message['replied_at']) . ' ago'; ?></small>
                            </div>
                        <? endif; ?>
                    <? endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <? if ($action == 'reply') : ?>
                        <button type="submit" class="btn bg-color">Send</button>
                    <? endif ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- #EEND# Modal -->