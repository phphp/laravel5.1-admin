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
				<th>queue</th>
				<th>payload</th>
				<th>attempts</th>
				<th>reserved</th>
				<th>available_at</th>
				<th>created_at</th>
			</tr>
		@foreach ( $jobs as $v )
			<tr>
				<td>{{ $v->id }}</td>
				<td>{{ $v->queue }}</td>
				<td>{{ $v->payload }}</td>
				<td>{{ $v->attempts }}</td>
				<td>{{ $v->reserved }}</td>
				<td>{{ $v->available_at }}</td>
				<td>{{ $v->created_at }}</td>
			</tr>
		@endforeach
		</table>
		{!! $jobs->render() !!}
	</div>

@stop


@section('tip')
<div class="tip-container">
    <i class="glyphicon glyphicon-info-sign"></i>
    <div class="tips">
        <dl class="list-unstyled">
            <dd>使用队列前需要先监听，在服务器端输入指令。</dd>
            <dd>如：php artisan queue:listen --queue=emails</dd>
        </dl>
    </div>
</div>
@stop
