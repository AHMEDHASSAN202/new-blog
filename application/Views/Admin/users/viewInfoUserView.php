<div class="modal fade" id="view-data" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-4">
                    <img style="height: 200px; width: 100%" src="<? echo imagesAssets($user->image); ?>" alt="profile avatar" class="img-fluid">
                </div>
                <div class="col-md-8 py-2">
                    <div class="my-2"><strong>Name: </strong> <? echo $user->first_name.' '.$user->last_name; ?></div>
                    <div class="my-2"><strong>Email: </strong> <? echo $user->email; ?></div>
                    <div class="my-2"><strong>Birthday: </strong> <? echo date('Y-m-d', $user->birthday); ?></div>
                    <div class="my-2"><strong>Gender: </strong> <? echo ($user->gender == 1) ? 'Male' : 'Female'; ?></div>
                    <div class="my-2"><strong>Status: </strong> <? echo ($user->status == 1) ? '<span class="text-success">enabled</span>' : '<span class="text-danger">disabled</span>' ; ?></div>
                    <div class="my-2"><strong>Created: </strong> <? echo date('Y-m-d', $user->created); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>