<div class="modal fade show" id="site-model" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-error"></div>
                <div class="modal-loader" style="display:none">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw text-size50 text-white"></i>
                </div>
                <div class="ContentDiv">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <p>Some text in the modal.</p>
                    <img src="{{ asset('images/loading.gif') }}" alt="" style="display:none" class="img-responsive" srcset="">
                    @yield('model-Content')
                </div>
            </div>
        </div>
    </div>
</div>
