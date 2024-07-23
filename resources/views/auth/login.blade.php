<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.png') }}" />
    <title>{{ config('app.name', 'Login Akademik') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('assets/metronics/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/metronics/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/metronics/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('assets/metronics/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" /> --}}
    {{-- <link href="{{ asset('assets/metronics/css/style.dark.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/metronics/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <!--begin::Page Vendor Stylesheets(used by this page)-->
    <link href="{{ asset('assets/metronics/plugins/custom/leaflet/leaflet.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/metronics/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />


</head>

<body>
    <div id="app">
        <main>
           <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm" style="border-radius: 20px; top: 15%">
                        <div class="card-header bg-primary">
                            <h3 class="card-title text-white fw-bolder">Masuk ke New Akademik</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <img src="{{ asset('assets/images/svg/sign-in.svg') }}" class="w-100" alt="">
                                {{-- Login Logo --}}
                                {{-- <div class="col-lg-6 text-center">
                                    <img src="{{ asset('assets/images/logo.png') }}" width="400" alt=""> --}}
                                </div>
                                <div class="col-lg-6">
                                    <form method="POST" action="{{ route('login') }}" class="mt-20">
                                        @csrf
                                        <h3 class="text-primary fs-1">Login untuk masuk ke halaman Dashboard</h3>
                                        <div class="row mb-5 mt-10">
                                            <label for="email">{{ __('NIM/NIP') }}</label>

                                            <div>
                                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                                @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <label for="password">{{ __('Password') }}</label>

                                            <div>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Login') }}
                                                </button>

                                                {{-- @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           </div>
        </main>
    </div>
</body>
<script src="{{ asset('assets/metronics/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{ asset('assets/metronics/js/scripts.bundle.js')}}"></script>
<script src="{{ asset('assets/metronics/js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
<!--begin::Global Javascript Bundle(used by all pages)-->
{{-- <script src="{{ asset('assets/metronics/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script> --}}
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('assets/metronics/js/custom/widgets.js')}}"></script>
{{-- <script src="{{ asset('assets/metronics/js/custom/apps/chat/chat.js')}}"></script> --}}
<script src="{{ asset('assets/metronics/js/custom/modals/create-app.js')}}"></script>
<script src="{{ asset('assets/metronics/js/custom/modals/upgrade-plan.js')}}"></script>
<script src="{{ asset('assets/metronics/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@if (session('error'))
<script>
    swal.fire({
        icon: 'error',
        title: 'Gagal',
        html: "{{ session('error') }}",
    });
</script>
@endif
@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    html: '@foreach($errors->all() as $error) {!! $error."<br>" !!}@endforeach',
})
</script>
@endif
</html>
