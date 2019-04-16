@extends(env('THEME').'.layouts.site')

@section('content')
    @include('auth.login_content')
@endsection
