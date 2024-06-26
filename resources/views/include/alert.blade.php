@if (isset($appAlert) && $appAlert)
<script>
  @if (count($errors) > 0)
      @foreach ($errors->all() as $error)
        $.notify("{{$error}}",'error');
      @endforeach
  @endif

  @if ($message = Session::pull('success'))
    $.notify('{{$message}}','success');
  @endif

  @if ($message = Session::pull('error'))
    $.notify('{{$message}}','error');
  @endif

</script>
@elseif (isset($appAlertType2) && $appAlertType2)
<script>
  @if (count($errors) > 0)
      @foreach ($errors->all() as $error)
        OneToast('{{$error}}' ,{type :'errors'});
      @endforeach
  @endif

  @if ($message = Session::pull('success'))
      OneToast('{{$message}}' ,{type :'error'});
  @endif

  @if ($message = Session::pull('error'))
    OneToast('{{$message}}' ,{type :'error'});
  @endif

</script>

@else
  @if (count($errors) > 0)
  <div class="alert alert-danger calltimer alert-dismissible w-50 mx-auto msg-class">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      @foreach ($errors->all() as $error)
          <p class="m-0"><i class="icon fa fa-times"></i> {{ $error }}</p>
  @endforeach
  </div>
  @endif
  @if ($message = Session::pull('success'))
  <div class="alert alert-success calltimer alert-dismissible w-50 mx-auto msg-class">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="m-0"><i class="icon fa fa-check"></i> {{ $message }}</p>
  </div>
  @endif
  @if ($message = Session::pull('error'))
  <div class="alert alert-danger calltimer alert-dismissible w-50 mx-auto msg-class">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p class="m-0"><i class="icon fa fa-times"></i> {{ $message }}</p>
  </div>
  @endif
@endif
