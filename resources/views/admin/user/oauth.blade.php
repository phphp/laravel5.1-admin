@extends('admin/main')


@section('title')所有 OAuth 用户@stop


@section('content')

	<div class="container">
		<div class="col-md-3 pull-right">
			<form class="form-inline" method="get" action="{{ route('admin_user_search') }}">
				<div class="form-group pull-right">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="id / name" name="q" value="{{ old('searchInput') }}" required="required">
						<div class="input-group-btn"><button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button></div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<p></p>

	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th>id</th>
				<th>user_id</th>
				<th>provider</th>
				<th>Oauth_id</th>
				<th>name</th>
				<th>nickname</th>
				<th>email</th>
				<th>avatar</th>
				<th>page</th>
				<th>created_at</th>
				<th>updated_at</th>
				<th>操作</th>
			</tr>
		@foreach ( $users as $v )
			<tr>
				<td><a href="{{ route('oauth_user_edit', ['id'=>$v->id]) }}">{{ $v->id }}</a></td>
				<td><a href="{{ route('user_show', ['id'=>$v->user_id]) }}">{{ $v->user_id }}</a></td>
				<td>{{ $v->provider }}</td>
				<td>{{ $v->open_auth_id }}</td>
				<td>{{ $v->name }}</td>
				<td>{{ $v->nickname }}</td>
				<td>{{ $v->email }}</td>
				<td><a href="{{ $v->avatar }}" target="_blank">头像</a></td>
				<td><a href="{{ $v->provider_user_link }}" target="_blank">链接</a></td>
				<td>{{ $v->created_at }}</td>
				<td>{{ $v->updated_at }}</td>
				<td>
					<a href="{{ route('oauth_user_edit', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('oauth_user_destroy', ['id'=>$v->id]) }}" method="post">
						<input type="hidden" name="_method" value="DELETE">
						{{csrf_field()}}
						<button class="confirm_button btn btn-danger btn-sm pull-left"><i class="glyphicon glyphicon-remove"></i></button>
					</form>
				</td>
			</tr>
		@endforeach
		</table>
		{!! $users->render() !!}
	</div>



@stop

