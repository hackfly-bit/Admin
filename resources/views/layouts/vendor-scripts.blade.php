<!-- JAVASCRIPT -->
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/metismenujs/metismenujs.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/eva-icons/eva.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.16.1/echo.iife.min.js"
    integrity="sha512-XYamWfde8fVJB0ruVwoA+rwH39JBVzBhQzQi22mV6aXMow3uCBWzN1ISCEkaJ2mZl2ktBZuteMoPKlMCGDwoPA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.16.1/echo.js" integrity="sha512-wGqDposamaADDdR/lXykxN/FS3rEgrbA7s0F5f8hgQkHbHc/2rDfAA609BjgzFgqbl2D4Drbnxyr5kR2vKxBCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js" integrity="sha512-tXL5mrkSoP49uQf2jO0LbvzMyFgki//znmq0wYXGq94gVF6TU0QlrSbwGuPpKTeN1mIjReeqKZ4/NJPjHN1d2Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    import Echo from 'laravel-echo';

    import Pusher from 'pusher-js';
    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: process.env.VITE_REVERB_APP_KEY,
        wsHost: process.env.VITE_REVERB_HOST,
        wsPort: process.env.VITE_REVERB_PORT ?? 80,
        wssPort: process.env.VITE_REVERB_PORT ?? 443,
        forceTLS: (process.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    });
</script> --}}
<script>
    // Initialize Pusher
    // import Pusher from '/node_modules/pusher-js';
    window.Pusher = Pusher;

    // Initialize Laravel Echo
    // window.Echo = new Echo({
    //     broadcaster: 'reverb',
    //     key: '{{ env('REVERB_APP_KEY') }}', // Use Blade syntax to echo your app key
    //     wsHost: '{{ env('REVERB_HOST') }}', // Use Blade syntax to echo your host
    //     wsPort: '{{ env('REVERB_PORT') }}' ?? 80, // Use Blade syntax to echo your port
    //     wssPort: '{{ env('REVERB_PORT') }}' ?? 443, // Use Blade syntax to echo your secure port
    //     forceTLS: ('{{ env('VITE_REVERB_SCHEME') }}'?? 'https') === 'https',
    //     enabledTransports: ['ws', 'wss'],
    // });

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: "f59cc3a03201d3aec976", //import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: "ap1", //import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true
    });
</script>
@yield('scripts')
