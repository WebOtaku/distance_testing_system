@extends ('layouts.master')

@section ('content')

    <login>

        <template slot="csrf">
            {{ csrf_field() }}
        </template>

        <template slot="errors">
            @include ('layouts.errors')
        </template>

    </login>

@endsection