@extends('layouts.app')
@php($selected="settings")
@section('head_title','Problems')
@section('icon', 'fas fa-clipboard-list')
@section('other_assets')
  <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css'/>
@endsection
@section('title','Problems')

@section('title_menu')
{{-- {% if user.level >= 2 %} --}}
<span class="title_menu_item"><a href="{{ url('problems/create') }}"><i class="fas fa-plus fa-lg color8"></i> Add</a></span>
<span class="title_menu_item"><a href="{{ url('submissions/all/assignments/0') }}"><i class="fas fa-list-ul fa-lg color8"></i>Review test submissions for problems</a></span>
<span class="title_menu_item"><a href="{{ url('problems/download_all') }}"><i class="fas fa-download fa-lg color8"></i>Download all problem's test and description</a></span>
@endsection

@section('content')
<div class="row">
	<div class="table-responsive">
	@error('messages')
		@php( $msgclasses = array('text-success'=> 'text-success', 'text-info'=> 'text-warning', 'text-danger'=> 'text-danger') )
		{{-- @php(dd($errors->get('messages'))) --}}
		{{-- @php(dd($message['type'])) --}}
		@foreach ($errors->get('messages') as $msg)
			<p class="text-danger">{{ $msg }}</p>
		@endforeach
	@enderror
	<table class="table table-striped table-bordered">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>ID</th>
				<th style="width: 20%">Name</th>
				<th style="width: 20%">Note</th>
				<th>Tags</th>
				<th>Languages</th>
				<th>Used in assignmnets</th>
				<th>diff<br/>command</th>
				<th>diff<br/>argument</th>
				<th>Tools</th>
			</tr>
		</thead>
	  @foreach ($problems as $item)
		<tr data-id="{{$item->id}}">
			<td> {{$loop->index}}</td>
			<td>{{ $item->id}}</td>
			<td><a href="{{ url("problems/$item->id") }}">{{ $item->name }}</a></td>
			<td>{{$item->admin_note}}</td>
			<td>
				@foreach ($item->tags as $tag)
			  		<span class="badge badge-pill badge-info">{{$tag->text}}</span>
			  	@endforeach
			</td>
			<td>
			  @foreach ($item->languages as $language_name)
			  <span class="badge badge-pill badge-secondary">{{$language_name->name}}</span>
			  @endforeach
			</td>
			<td>
				{{-- {% for ass_id in item.assignments %}
					<a href="{{ site_url("assignments/edit/#{ass_id}") }}" class="badge badge-primary">asgmt {{ ass_id}}</a>
				{% endfor %} --}}
			</td>
			<td>{{ $item->diff_cmd }}</td>
			<td>{{ $item->diff_arg }}</td>
			
			<td>
				<a href="{{ route('problems.download_zip',$item->id) }}">
					<i title="Download Tests and Descriptions" class="fa fa-cloud-download-alt fa-lg color11"></i>
				</a>
				<a href="{{ route('problems.edit', $item) }}"> <i title="Edit" class="far fa-edit fa-lg color3"> </i> </a>
				<span title="Delete problem" class="del_n delete_tag pointer">
				  <i title="Delete problem" class="far fa-trash-alt fa-lg color1"></i>
				</span>
			  
			</td>
		
		</tr>
	  @endforeach
	</table>
	</div>
</div>

<div class="modal fade" id="problem_delete" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Are you sure you want to delete this tag?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
		  	<div class="modal-footer">
				<button type="button" class="btn btn-danger confirm-tag-delete">YES</button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">NO</button>
		  	</div>
		</div>
	</div>
</div>
@endsection


@section('body_end')
<script type='text/javascript' src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script>
/**
* Notifications
*/
  $(document).ready(function () {
	$('.del_n').click(function () {
	  var row = $(this).parents('tr');
	  var id = row.data('id');
		$(".confirm-tag-delete").off();
		$(".confirm-tag-delete").click(function(){
		  $("#problem_delete").modal("hide");
			$.ajax({
			  type: 'DELETE',
			  url: '{{ route('problems.index') }}/'+id,
			  data: {
						  '_token': "{{ csrf_token() }}",
			  },
			  error: shj.loading_error,
			  success: function (response) {
				if (response.done) {
				  row.animate({backgroundColor: '#FF7676'},100, function(){row.remove();});
				  $.notify('problem deleted'	, {position: 'bottom right', className: 'success', autoHideDelay: 5000});
				  $("#problem_delete").modal("hide");
				}
				else
				  shj.loading_failed(response.message);
			  }
			});
		});
	  $("#problem_delete").modal("show");
	});

	$("table").DataTable({
		"pageLength": 10,
		"lengthMenu": [ [10, 20, 30, 50, -1], [10, 20, 30, 50, "All"] ]
	});
  });
</script>
@endsection

