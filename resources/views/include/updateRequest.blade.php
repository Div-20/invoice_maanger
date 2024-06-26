
@if (isset($add_new_url) && $add_new_url)
<a href="{{ $add_new_url }}" class="btn btn-success rounded-0" style="margin:10px;"><i class="fa fa-plus"></i> Add</a>
@endif
@if (isset($add_ajax_url) && $add_ajax_url)
<a href="javascript:void(0)" onclick="openPopup('{{ $add_ajax_url }}')" class="btn btn-danger rounded-0" style="margin:10px;"><i class="fa fa-plus"></i> Add</a>
@endif

{{-- <input type="submit" class="btn btn-info btn-flat" value="active" name="active" style="margin:10px;">
<input type="submit" class="btn btn-warning btn-flat" value="inactive" name="inactive" style="margin:10px;"> --}}
<input type="submit" class="btn btn-danger btn-flat" value="delete" name="delete" style="margin:10px;">
@if (isset($extra_urls) && count($extra_urls))
    @foreach ($extra_urls as $url)
        <a href="{{ $url['url'] }}" class="btn btn-success rounded-0" style="margin:10px;"><i class="fa fa-plus"></i> {{ $url['title'] }}</a>
    @endforeach
@endif

@if (isset($servicePanel) && $servicePanel)
<input type="submit" class="btn btn-success btn-flat" value="Show On Web" name="webShow" style="margin:10px;">
<input type="submit" class="btn btn-danger btn-flat" value="Hide On Web" name="webHide" style="margin:10px;">
@endif
@if (isset($serviceCenterPanel) && $serviceCenterPanel)
<input type="submit" class="btn btn-success btn-flat" value="Featured" name="Featured" style="margin:10px;">
<input type="submit" class="btn btn-danger btn-flat" value="UnFeatured" name="UnFeatured" style="margin:10px;">
@endif
@if (isset($productpanel) && $productpanel)
<input type="submit" class="btn btn-success btn-flat" value="Approved" name="Approved" style="margin:10px;">
<input type="submit" class="btn btn-danger btn-flat" value="Pending" name="Pending" style="margin:10px;">
@endif
@if (isset($bookingPanel) && $bookingPanel)
<input type="submit" class="btn btn-warning btn-flat" value="Refund &amp; Cancel" name="refundCancel" style="margin:10px;">
{{-- <input type="submit" class="btn btn-info btn-flat" value="Txn. Receipt" name="confirmPaymentMSG" style="margin:10px;background: red;border-color: red;"> --}}
{{-- <input type="submit" class="btn btn-secondary btn-flat" value="Re-Book" name="reBooking" style="margin:10px;background: #000;color: #fff;"> --}}
<input type="submit" class="btn btn-info btn-flat" value="Complete Booking" name="completestatus" style="margin:10px;">
<input type="submit" class="btn btn-danger btn-flat" value="Role Back" name="rolBack" style="margin:10px;">
@endif
@if (isset($activateRegion) && $activateRegion)
<input type="submit" class="btn btn-secondary btn-flat" value="Active Region" name="activeRegion" style="margin:10px;background: #000;color: #fff;">
<input type="submit" class="btn btn-info btn-flat" value="Deactivate Region" name="deactivateRegion" style="margin:10px;background: red;border-color: red;">
@endif
