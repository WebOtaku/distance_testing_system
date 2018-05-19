@extends ('layouts.master')

@section ('content')

    <div class="workspace">

        @include ('layouts.nav')

        <section class="section view_section">

            <router-view>

                <template slot="csrf">
                    {{ csrf_field() }}
                </template>

            </router-view>

        </section>

    </div>

@endsection