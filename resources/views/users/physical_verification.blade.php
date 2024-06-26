@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="qrcodeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrcodeModalLabel">Asset</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
                </div>
                {{ Form::open(['url' => route('user.asset.review'), 'method' => 'POST', 'id' => 'asset_review_frm']) }}


                <div class="modal-body">

                    <table>
                        <tr>
                            <th rowspan="4" class="pr-2 w-0">
                                <div class="border_right pr-2">
                                    {!! QrCode::generate(url('user/qrcode/' . $asset->unique_id)) !!}
                                </div>
                            </th>
                            <th colspan="2" class="pl-2 border_bottom w-50"><strong>{{ $asset->unique_id }}</strong></th>
                        </tr>
                        <tr class="pl-2">
                            <th>Building:</th>
                            <td>{{ $asset->building_block->building->name }}</td>
                        </tr>
                        <tr class="pl-2">
                            <th>Type:</th>
                            <td>{{ $asset->asset_type->name }}</td>
                        </tr>
                        <tr class="pl-2">
                            <th>Name:</th>
                            <td>{{ json_decode($asset->asset_json)->asset_name }}</td>
                        </tr>
                    </table>


                    <div class="form-group row">
                        <label>Do you want any correction in asset detail ?</label>
                        <div class="col-md-8 col-sm-12">
                            <label class="btn btn-primary btn-raised waves-effect font-bold approve">
                                <input type="radio" name="status" class="mr-2 status" value="1" required="">
                                Yes
                            </label>
                            <label class="btn btn-warning btn-raised waves-effect font-bold reject">
                                <input type="radio" name="status" class="mr-2 status" checked value="2"
                                    required="">
                                No
                            </label>
                        </div>
                    </div>
                    <div id="review_div">
                        <label for="remark" class="form-label">Remark</label>
                        <div class="input-group">
                            <div class="form-line">
                                <textarea class="form-control" name="remark" rows="5" cols="90" id="updated_remark"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="qr_code" value="{{ $asset->unique_id }}" />
                <div class="modal-footer">

                    <button type="submit" class="btn btn-secondary ">submit</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    @endsection
    @push('add-script')
    <script>
            $(function() {

                $('#qrcodeModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#qrcodeModal').modal('show');
                $('.close').click(function() {
                    $('#qrcodeModal').modal('toggle');
                });
                $("#review_div").hide();
                $("input[type='radio']").click(function() {
                    if ($("input[type='radio']:checked").val() == 1) {
                        $("#review_div").show();
                        $("#updated_remark").prop('required', true);
                    } else {
                        $("#review_div").hide();
                        $("#updated_remark").prop('required', false);
                    }
                });
            });
        </script>
   @endpush
