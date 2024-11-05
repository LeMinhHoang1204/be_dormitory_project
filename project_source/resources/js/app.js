import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '93fd8aeba9d1b2cd6e0a',  // Thay bằng PUSHER_APP_KEY từ file .env của bạn
    cluster: 'ap1',               // Thay bằng PUSHER_APP_CLUSTER từ file .env của bạn
    forceTLS: true
});

window.Echo.channel('be-dormitory-channel')
    .listen('.user-login', (data) => {
        console.log('User login event received:', data);
        toastr.success(`${data.email} has joined our website`);
    });


