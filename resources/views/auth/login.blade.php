@extends('template.app')

@section('content')


<div class="text-center mb-4" >
    <a href="#" class="navbar-brand navbar-brand-autodark"><img style="z-index:1000;" src="<?= asset('landing/login/img/logo.gif') ?>" height="100" alt=""></a>
</div>
@if ($message = Session::get('success'))
      <div class="alert alert-success alert-block" style="z-index:1000;">
        <button type="button" class="close" data-dismiss="alert">×</button>	
          <strong>{{ $message }}</strong>
      </div>
    @endif
<form class="card card-md" action="<?= route('login') ?>" method="POST" autocomplete="off" style="z-index:1000;">
    @csrf
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Masuk menggunakan Akunmu</h2>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukan email" autocomplete="off">
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-2">
            <label class="form-label">
                Password
            </label>
            <div class="input-group input-group-flat">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" autocomplete="off">
            </div>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
		<div class="form-footer text-center" hidden>
			<span class="underbutton">
				Belum Punya Akun ? <a href="{{ url('/register') }}">Daftar</a>
			</span>
		</div>
    </div>
</form>

@endsection