@extends('template.app')

@section('content')


<div class="text-center mb-4">
    <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= asset('landing/login/assets/img/nav-logo.png') ?>" height="100" alt=""></a>
</div>
<form class="card card-md" action="<?= route('daftar.pengguna') ?>" method="POST" autocomplete="off" style="z-index:1000;">
    @csrf
    <div class="card-body">
        <h2 class="card-title text-center mb-4">Daftar Akun Pelanggan</h2>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukan email" autocomplete="off">
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
		<div class="mb-3">
            <label class="form-label">Nama Pengguna</label>
            <input type="text" name="nama" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukan Nama Pengguna" autocomplete="off">
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
		<div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('name') }}" placeholder="Masukan Nomor Handphone" autocomplete="off">
        </div>
		<div class="mb-3" hidden>
            <label class="form-label">Level</label>
            <input type="text" name="level" class="form-control" value="Pelanggan" autocomplete="off">
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
			
        </div>
		<div class="form-footer text-center">
			<span class="underbutton">
				Sudah Punya Akun ? <a href="{{ url('/login') }}">Masuk</a>
			</span>
		</div>
    </div>
</form>

@endsection