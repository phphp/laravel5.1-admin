@extends('admin/main')


@section('title')编辑 OAuth 用户@stop


@section('content')

	<div class="col-md-7">
		<form action="{{ route('oauth_user_update', ['id'=>$user->id]) }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			{{ method_field('PATCH') }}

			<div class="form-group">
				<label><a href="{{ route('user_show', ['id'=>$user->user_id]) }}">归属用户 ID</a></label>
				<input type="text" class="form-control" name="user_id" placeholder="" value="{{ $user->user_id }}" required="required">
			</div>
			<div class="form-group">
				<label>provider</label>
				<input type="text" class="form-control" name="provider" placeholder="" value="{{ $user->provider }}" disabled>
				<input type="hidden" name="provider" value="{{ $user->provider }}">
			</div>
			<div class="form-group">
				<label>OAuth ID</label>
				<input type="text" class="form-control" name="open_auth_id" placeholder="" value="{{ $user->open_auth_id }}" disabled>
			</div>
			<div class="form-group">
				<label>name</label>
				<input type="text" class="form-control" name="name" placeholder="" value="{{ $user->name }}" disabled>
			</div>
			<div class="form-group">
				<label>nickname</label>
				<input type="text" class="form-control" name="nickname" placeholder="" value="{{ $user->nickname }}" disabled>
			</div>
			<div class="form-group">
				<label>email</label>
				<input type="text" class="form-control" name="email" placeholder="" value="{{ $user->email }}" disabled>
			</div>
			<div class="form-group">
				<label>头像</label>
				<img src="{{ $user->avatar }}">
			</div>
			<div class="form-group">
				<label>acccess_token</label>
				<input type="text" class="form-control" name="acccess_token" placeholder="" value="{{ $user->acccess_token }}" disabled>
			</div>
			<div class="form-group">
				<label>refresh_token</label>
				<input type="text" class="form-control" name="refresh_token" placeholder="" value="{{ $user->refresh_token }}" disabled>
			</div>
			<div class="form-group">
				<label>expires_in</label>
				<input type="text" class="form-control" name="expires_in" placeholder="" value="{{ $user->expires_in }}" disabled>
			</div>
			<div class="form-group">
				<label>created_at</label>
				<input type="text" class="form-control" name="created_at" placeholder="" value="{{ $user->created_at }}" disabled>
			</div>
			<div class="form-group">
				<label>updated_at</label>
				<input type="text" class="form-control" name="updated_at" placeholder="" value="{{ $user->updated_at }}" disabled>
			</div>
			<button type="submit" class="btn btn-primary">修改用户</button>
		</form>
	</div>


@stop

