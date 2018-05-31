@extends ('layouts.master')

@section ('content')

    <div class="workspace">

        @include ('layouts.nav')

        <router-view></router-view>

    </div>

@endsection