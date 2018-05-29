@extends ('layouts.master')

@section ('content')

    <div class="workspace">

        @include ('layouts.nav')

        <section class="section view_section">

            <router-view></router-view>

        </section>

    </div>

@endsection