<x-layouts.auth>
    <form class="user" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <input type="text" name="username"
                class="form-control form-control-user @error('username') is-invalid @enderror" id="username"
                aria-describedby="emailHelp" placeholder="Masukkan email/username anda..." value="{{ old('username') }}"
                autocomplete="username" autofocus>

            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" name="password"
                class="form-control form-control-user @error('password') is-invalid @enderror" id="password"
                placeholder="Masukkan password" autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox small">
                <input type="checkbox" name="remember" class="custom-control-input" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">
                    Ingat Saya
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Masuk Ke Akun
        </button>
        <hr>
    </form>
</x-layouts.auth>
