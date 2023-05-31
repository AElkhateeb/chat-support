
@extends( 'ceo.layout.master')


@section('styles')
     <link rel="stylesheet" href="{{URL::asset('css/style.css')}}" />
@endsection
@section('header')
    @include('ceo.partials.header')
@endsection

@section('content')

    <div class="app-body">

        @if(View::exists('ceo.layout.sidebar'))
            @include('ceo.layout.sidebar')
        @endif

        <main class="main">

            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>

                @yield('body')
            </div>
        </main>
    </div>
@endsection

@section('footer')
    @include('admin.partials.footer')
@endsection

@section('bottom-scripts')
    @parent
@endsection
