<div id="accordion">
    <div class="card mb-0">
        <div class="bg-secondary card-header">
            <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                <h4 class="card-title text-white w-100 m-0">Filter</h4>
            </a>
        </div>
        <div id="collapseOne" class="collapse @if ($aQuery) show @endif" data-parent="#accordion">
            <div class="card-body">
                <form method="get" action="" class="stop-loading">
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-sm-0 mb-2">
                            <div class="form-group">
                                <label>Full Name / email / Mobile </label>
                                <input type="text" name="search" id=""
                                    value="{{ $aQuery['search'] ?? old('search') }}" class="form-control"
                                    placeholder="Enter search request">
                            </div>
                        </div>
                        <div class="col-sm-6 mb-sm-0 mb-2">
                            <div class="form-group">
                                <label for="">Total Entry per page</label>
                                <input type="number" min="0" name="paginate" class="form-control"
                                    value="{{ $aQuery['paginate'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select User Role</label>
                                        {!! Form::select(
                                            'role',
                                            ['' => '---Select Role Type---'] + ($roles ?? []),
                                            $aQuery['role'] ?? '',
                                            ['class' => 'form-control'],
                                        ) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Select Prime Status</label>
                                        {!! Form::select(
                                            'prime',
                                            [
                                                '' => '---Select---',
                                                'prime' => 'Prime User',
                                                'non-prime' => 'Expire Prime User',
                                            ],
                                            $aQuery['prime'] ?? '',
                                            ['class' => 'form-control'],
                                        ) !!}
                                    </div>
                                </div> --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Filter Block User</label>
                                        {!! Form::select(
                                            'blocked',
                                            [
                                                '' => '---Select Status---',
                                                'blocked' => 'Blocked User',
                                                'unblocked' => 'Un Blocked User',
                                            ],
                                            $aQuery['blocked'] ?? '',
                                            ['class' => 'form-control'],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 content-cc">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;Search</button>
                            <a href="{{ Request::url() }}"><input type="button" value="Reset" class="ml-2 btn btn-secondary"></a>
                        </div>
                    </div>
                    {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
