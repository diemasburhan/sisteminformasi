#!/bin/bash

# Pastikan dijalankan sebagai root
if [ "$EUID" -ne 0 ]; then
  echo "Harap jalankan script ini menggunakan sudo: sudo ./setup_nginx_ssl.sh"
  exit
fi

echo "Memindahkan konfigurasi Nginx..."
mv /var/www/lpkia/sisteminformasi/sisteminformasi.conf /etc/nginx/sites-available/sisteminformasi.lpkia.ac.id

echo "Membuat symlink untuk mengaktifkan situs..."
ln -sf /etc/nginx/sites-available/sisteminformasi.lpkia.ac.id /etc/nginx/sites-enabled/

echo "Mengetes konfigurasi Nginx..."
nginx -t

if [ $? -eq 0 ]; then
    echo "Reload Nginx..."
    systemctl reload nginx

    echo "Menjalankan Certbot untuk instalasi SSL..."
    certbot --nginx -d sisteminformasi.lpkia.ac.id --non-interactive --agree-tos --register-unsafely-without-email

    echo "Selesai! Domain https://sisteminformasi.lpkia.ac.id kini aktif dan aman."
else
    echo "Terdapat kesalahan pada konfigurasi Nginx. Proses dihentikan."
fi
