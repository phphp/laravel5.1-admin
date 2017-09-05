@extends('admin/main')


@section('title')用户列表@stop


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
				<?php
					$order = $order=='desc' ? 'asc' : null;
					$route = isset($key) ? 'admin_user_search' : 'user_index';
					$q = isset($key) ? "q=$key" : null;
				?>
				<th><a href="{{ route($route, ['orderBy'=>'id', 'order'=>$order, $q]) }}">ID <i class="glyphicon glyphicon-sort"></i></a></th>
				<th><a href="{{ route($route, ['orderBy'=>'name', 'order'=>$order, $q]) }}">name <i class="glyphicon glyphicon-sort"></i></a></th>
				<th>avatar</th>
				<th>email</th>
				<th><a href="{{ route($route, ['orderBy'=>'active', 'order'=>$order, $q]) }}">active <i class="glyphicon glyphicon-sort"></i></a></th>
				<th><a href="{{ route($route, ['orderBy'=>'admin', 'order'=>$order, $q]) }}">admin <i class="glyphicon glyphicon-sort"></i></a></th>
				<th><a href="{{ route($route, ['orderBy'=>'created_at', 'order'=>$order, $q]) }}">created at <i class="glyphicon glyphicon-sort"></i></a></th>
				<th><a href="{{ route($route, ['orderBy'=>'updated_at', 'order'=>$order, $q]) }}">updated at <i class="glyphicon glyphicon-sort"></i></a></th>
				<th>操作</th>
			</tr>
		@foreach ( $users as $v )
			<tr>
				<td>{{$v->id}}</td>
				<td><a href="{{ route('user_show', ['id'=>$v->id]) }}">{{$v->name}}</a></td>
				<td><img width="30px" src="/uploads/avatar/{{$v->avatar}}-s.jpg"></td>
				<td>{{$v->email}}</td>
				<td>{{$v->active}}</td>
				<td>{{$v->admin}}</td>
				<td>{{$v->created_at->format('Y-m-d')}}</td>
				<td>{{$v->updated_at->format('Y-m-d')}}</td>
				<td>
					<a href="{{ route('user_edit', ['id'=>$v->id]) }}">
						<button class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i></button>
					</a>
					<form class="pull-left" action="{{ route('user_destroy', ['id'=>$v->id]) }}" method="post">
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

