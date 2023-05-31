@extends('support.layout.master')


@section('header')
    @include('support.partials.header')
@endsection

@section('content')

    <div class="app-body">

        <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>

                @yield('body')
            </div>

        <!--main class="main">

           
        </main-->
    </div>
@endsection

@section('footer')
    @include('support.partials.footer')
@endsection

@section('bottom-scripts')
    @parent
@endsection
