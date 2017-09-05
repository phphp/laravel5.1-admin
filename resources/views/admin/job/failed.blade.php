@extends('admin/main')


@section('title')待执行队列@stop


@section('content')


	<ol class="breadcrumb">
		<li><a href="{{ route('admin_queues') }}" {!! is_route('admin_queues') ? 'style="color:#555"' : '' !!}>待执行队列</a></li>
		<li><a href="{{ route('admin_queues_failed') }}" {!! is_route('admin_queues_failed') ? 'style="color:#555"' : '' !!}>失败队列</a></li>
	</ol>
	<p></p>

	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th>ID</th>
				<th>connection</th>
				<th>queue</th>
				<th>payload</th>
				<th>failed_at</th>
			</tr>
		@foreach ( $jobs as $v )
			<tr>
				<td>{{ $v->id }}</td>
				<td>{{ $v->connection }}</td>
				<td>{{ $v->queue }}</td>
				<td>{{ $v->payload }}</td>
				<td>{{ $v->failed_at }}</td>
			</tr>
		@endforeach
		</table>
		{!! $jobs->render() !!}
	</div>

@stop
