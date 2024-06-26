<div class="modal-header p-0">
    <h4 class="modal-title">Make Prime</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="py-3">
    <div class="box-body">
        {!! Form::open( ['action' => ['App\Http\Controllers\AdminControllers\UserController@makeUserPrime',$aRow->id] , 'role'=>'form' , 'enctype' =>"multipart/form-data", "onsubmit" => "return submitFrm(this)"]) !!}
        <div class="mx-0">
            <div class="form-group">
                <label for="">User Name</label>
                <input name="" readonly class="form-control" value="{{$aRow->name}}">
            </div>
            <div class="form-group">
                <label for="">Prime End Date</label>
                <input type="date" name="prime" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info float-right">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>