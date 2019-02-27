@extends('layout.master')

@section('content')
<div class="container">
	<div style="padding-top: 83px;max-width: 400px;width: 100%;margin: 0 auto;">
		<form method="post" action="{{URL::to('postLogin')}}">
      	@csrf
		  <div class="form-group">
		    <label>ID</label>
		    <input type="text" class="form-control <?php if(Session::has('username')) echo "is-invalid"; ?>" id="username" name="username" value="{{ old('username') }}" style="border: 1px solid black;border-radius: 10px 10px 10px 10px;">
		    @if (Session::has('username'))
		    <div class="invalid-feedback">{{Session::get('username')}}</div>
		    @endif
		  </div>
	  
		  <div class="form-group">
		    <label>パスワード</label>
		    <input type="password" class="form-control <?php if(Session::has('password')) echo "is-invalid"; ?>" id="password" name="password" value="{{ old('password') }}" style="border: 1px solid black;border-radius: 10px 10px 10px 10px;">
		    @if (Session::has('password'))
		    <div class="invalid-feedback">{{Session::get('password')}}</div>
		    @endif
		  </div>
	    <button type="submit" class="btn btn-primary" style="color: white;background: #005BAB;width: 100%;border-radius: 10px 10px 10px 10px;margin-top: 4%;>">ログイン</button>

	</form>

</div>
@stop