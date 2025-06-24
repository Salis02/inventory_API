import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 10, // 10 virtual users
  duration: '5s',
};

const token = 'Bearer 7|3iAGv7AtSj9aoDj7kCZprsvYpp7m7eV5OCKopwwC15041e4a'; // Ambil dari hasil login

export default function () {
  const payload = JSON.stringify({
    barang_id: 5,
    tanggal: '2025-06-24',
    tipe_transaksi: 'masuk',
    jumlah: 1,
  });

  const headers = {
    'Authorization': token,
    'Content-Type': 'application/json',
  };

  const res = http.post('http://127.0.0.1:8000/api/transaksis', payload, { headers });

  check(res, {
    'status was 200 or 400': (r) => r.status === 200 || r.status === 400,
  });

  sleep(1);
}
