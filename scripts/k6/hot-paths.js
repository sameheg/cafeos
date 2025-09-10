import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  stages: [
    { duration: '30s', target: 20 },
    { duration: '1m', target: 20 },
    { duration: '30s', target: 0 },
  ],
};

const BASE_URL = __ENV.BASE_URL || 'http://localhost';

export default function () {
  http.get(`${BASE_URL}/api/v1/pos/menu-items`);
  sleep(1);
}
