import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const broadcaster = import.meta.env.VITE_BROADCAST_DRIVER ?? 'pusher';

window.Echo = new Echo({
  broadcaster,
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
  wsHost: import.meta.env.VITE_PUSHER_HOST ?? window.location.hostname,
  wsPort: import.meta.env.VITE_PUSHER_PORT ?? 6001,
  wssPort: import.meta.env.VITE_PUSHER_PORT ?? 6001,
  forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
  enabledTransports: ['ws', 'wss'],
});
