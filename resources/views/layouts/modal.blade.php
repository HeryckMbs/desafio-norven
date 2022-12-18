<div class="modal-dialog @yield('size', 'modal-lg')">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h5 class="modal-title">@yield('title')</h5>
        </div>

        @yield('form')

        <div class="modal-body">
            @yield('content')
        </div>

        <div class="modal-footer">
            @yield('footer')
        </div>

        @yield('closeform')
    </div>

    {{-- <script type="text/javascript" src="{{ asset('/bower_components/LTR/default/assets/js/pages/form_layouts.js') }}"> --}}
    {{-- </script> --}}
    {{-- <script type="text/javascript" src="{{ asset('/js/custom.js') }}"></script> --}}

</div>
