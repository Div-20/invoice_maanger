@inject('mediaObj', 'App\Models\Media')
<div class="modal-header p-0">
    <h4 class="modal-title">Contact Us</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="py-3">
    <div class="card-body">
      <strong><i class="fas fa-user mr-1"></i> Name</strong>
      <p class="text-muted">{{ $aRow->user_name }}</p>
      <hr>
      <strong><i class="fas fa-map-marker-alt mr-1"></i> Email</strong>
      <p class="text-muted">{{ $aRow->user_email }}</p>
      <hr>
      <strong><i class="fas fa-pencil-alt mr-1"></i> Mobile</strong>
      <p class="text-muted">{{ $aRow->user_mobile }}</p>
      <hr>
      <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
      <p class="text-muted">{{ $aRow->content }}</p>
    </div>
    @if ($aRow->media)                            
        <a href="{{asset($mediaObj::$directory[$mediaObj::LEADS] . $aRow->media->file_name)}}" target="_BLANK"><div class="border border-dashed bg-light p-4 text-center">Click To View Document</div></a>
    @endif
</div>
