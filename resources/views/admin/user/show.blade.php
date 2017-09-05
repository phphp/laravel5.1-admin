@extends('admin/main')


@section('title')用户信息@stop


@section('content')

	<h4>{{ $user->name }}</h4>
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>name</th>
				<th>avatar</th>
				<th>active</th>
				<th>admin</th>
				<th>created_at</th>
				<th>updated_at</th>
			</tr>
			<tr>
				<td>{{$user->id}}</td>
				<td>{{$user->name}}</td>
				<td><img src="/uploads/avatar/{{$user->avatar}}-s.jpg"></td>
				<td>{{$user->active}}</td>
				<td>{{$user->admin}}</td>
				<td>{{$user->created_at}}</td>
				<td>{{$user->updated_at}}</td>
			</tr>
		</table>
	</div>

	<hr>

	<h4>所属角色</h4>
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>角色名称</th>
			</tr>
		@foreach ( $roles as $v )
			<tr>
				<td>{{$v->id}}</td>
				<td><a href="{{route('role_show', ['id'=>$v->id])}}">{{$v->name}}</a></td>
			</tr>
		@endforeach
		</table>
	</div>
	
	<hr>

	<h4>OAuth</h4>
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>provider</th>
			</tr>
		@foreach ( $oauthUsers as $v )
			<tr>
				<td>{{$v->id}}</td>
				<td><a href="{{route('oauth_user_edit', ['id'=>$v->id])}}">{{$v->provider}}</a></td>
			</tr>
		@endforeach
		</table>
	</div>

@stop

