@extends('admin/main')


@section('title')后台首页@stop


@section('content')


<div class="row today">
	<div class="col-md-3">
		<div class="info-header"><h5>注册<b>{{ count($users) }}</b>昨日 {{ count($yesterdayUsers) }}</h5></div>
		<div class="info-body">
			@foreach ( $users as $k=>$user )
			<?php if ( $k>5 ) break; ?>
			<p><a href="{{ route('user_show', ['id'=>$user->id]) }}">{{ $user->name }}</a></p>
			@endforeach
		</div>
	</div>
	<div class="col-md-3">
		<div class="info-header"><h5>文章<b>{{ count($posts) }}</b>昨日 {{ count($yesterdayPosts) }}</h5></div>
		<div class="info-body">
			@foreach ( $posts as $k=>$post )
			<?php if ( $k>5 ) break; ?>
			<p><a href="{{ route('admin_show_post', ['id'=>$post->id]) }}">{{ $post->title }}</a></p>
			@endforeach
		</div>
	</div>
</div>


<div class="row today">
	<div class="col-md-3">
		<div class="info-header"><h5>日志<a href="{{ route('admin_logs') }}" target="_bland"><b>{{ $logs }}</b></a></h5></div>
	</div>
</div>


@stop
