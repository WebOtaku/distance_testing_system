@extends ('layouts.master')

@section ('content')

    <registration>

        <template slot="csrf">
            {{ csrf_field() }}
        </template>

        <template slot="errors">
            @include ('layouts.errors')
        </template>

    </registration>

@endsection