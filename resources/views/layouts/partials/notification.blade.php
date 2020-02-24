@if(Session::has('notification.message'))
<div class="container">
	<div class="alert alert-{{ Session::get('notification.type') }} alert-dismissible fade show" role="alert">
	  {{ Session::get('notification.message') }}
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
</div>
@endif