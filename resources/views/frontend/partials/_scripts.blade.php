    <!--========= JS LINK PART START =====-->
    <script src="{{ asset('frontend/lib/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/lib/swiper/swiper-initialize.js') }}"></script>

    <!-- For Toster Notifications -->
    <script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>

    @stack('js')

    <!-- custom javascript -->
    <script type="application/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script type="text/javascript">
        @if (session('success'))
            iziToast.success({
                title: 'Success',
                message: '{{ session('success') }}',
                position: 'topRight'
            });
        @endif

        @if (session('error'))
            iziToast.error({
                title: 'Error',
                message: '{{ session('error') }}',
                position: 'topRight'
            });
        @endif

        @if (session('warning'))
            iziToast.error({
                title: 'Warning',
                message: '{{ session('warning') }}',
                position: 'topRight'
            });
        @endif
    </script> 

    @livewireScripts

    @stack('livewire')


    <!-- App custom js -->
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <!--========= JS LINK PART END ==========-->
