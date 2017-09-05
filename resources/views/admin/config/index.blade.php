@extends('admin/main')


@section('title')编辑配置文件@stop


@section('content')

<div class="col-md-8">

<form method="POST" action="{{ route('admin_config_update', ['file'=>$file]) }}">
    <p>编辑：{{$file}}</p>
    <div class="form-group">
        {{csrf_field()}}
        <textarea class="form-control" rows="35" name="contents">{{$contents}}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">提交修改</button>
</form>
</div>

<div class="col-md-4">
    <h5>配置文件</h5>
    <ul class="list-unstyled">
    @foreach ( $files as $v )
        <li><a href="{{route('admin_config', "file=$v")}}" <?php if ( $file == $v ) echo 'style="color:#333;font-weight:600"' ?>>{{$v}}</a></li>
    @endforeach
    </ul>
</div>

@stop


@section('tip')
<div class="tip-container">
    <i class="glyphicon glyphicon-info-sign"></i>
    <div class="tips">
        <dl class="list-unstyled">
            <dd>配置文件在服务器端需要有读写权限。</dd>
            <dd>默认 laravel 自带的配置文件没有写权限；后台使用的配置文件拥有读写权限，如 admin.php, captcha.php。</dd>
        </dl>
    </div>
</div>
@stop
