<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery/dist/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/modules/popper.js/dist/popper.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
<script src="{{ asset('assets/modules/izitoast/dist/js/iziToast.min.js') }}"></script>
@yield('scripts')

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    @if(session('success'))
    iziToast.success({
        title: 'Success',
        message: '{{ session('success') }}',
        position: 'topRight'
    });
    @endif

    @if(session('error'))
    iziToast.error({
        title: 'Error',
        message: '{{ session('error') }}',
        position: 'topRight'
    });
    @endif

</script>
<script src="{{ asset('assets/js/comfirm-delete.js') }}"></script>

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const beep = document.getElementById("myAudio1");

        function sound() {
            beep.play();
        }
        // web_token
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
            apiKey: "{{ setting('firebase_api_key') }}",
            authDomain: "{{ setting('firebase_authDomain') }}",
            projectId:"{{ setting('projectId') }}",
            storageBucket:"{{ setting('storageBucket') }}",
            messagingSenderId: "{{ setting('messagingSenderId') }}",
            appId: "{{ setting('appId') }}",
            measurementId: "{{ setting('measurementId') }}",
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        startFCM();

        function startFCM() {
            messaging.requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajax({
                        url: '{{ route('store.token') }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                        },
                        error: function(error) {
                        },
                    });

                }).catch(function(error) {});
        }
        messaging.onMessage(function(payload) {
            const title = payload.data.title;
            const body = payload.data.body;

            sound();
            $('#custom-width-modal').modal('show');
            $('#notificationTitle').text(title);
            $('#notificationBody').text(body);


            new Notification(title, {
                body: body,
            });
        });

    });
</script>

