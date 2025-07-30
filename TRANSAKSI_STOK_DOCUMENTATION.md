# Dokumentasi Sistem Transaksi Stok

## Overview

Sistem transaksi stok yang telah dimodifikasi menggunakan alur berbasis query URL dan session untuk keranjang transaksi.

## Fitur Utama

### 1. **Pilihan Jenis Transaksi dengan Query URL**

-   User memilih jenis transaksi (masuk/keluar) terlebih dahulu
-   Setelah dipilih, form akan disabled/locked pada jenis yang dipilih
-   URL akan memiliki parameter `?jenis=masuk` atau `?jenis=keluar`

### 2. **Form Transaksi Dinamis**

-   Form transaksi hanya muncul setelah jenis dipilih
-   Field pemasok hanya muncul untuk transaksi masuk
-   Field pemasok wajib diisi untuk transaksi masuk
-   Validasi stok untuk transaksi keluar

### 3. **Session-based Shopping Cart**

-   Item ditambahkan ke session sebelum disimpan ke database
-   Dapat menambahkan multiple items ke keranjang
-   Setiap item memiliki unique key berdasarkan barang_id + pemasok_id
-   Jika item sama ditambahkan lagi, quantity akan bertambah

### 4. **Manajemen Keranjang**

-   Lihat semua item dalam keranjang
-   Hapus item individual dari keranjang
-   Kosongkan seluruh keranjang
-   Proses semua transaksi sekaligus

## Alur Kerja (Workflow)

```
1. User mengakses halaman form transaksi
   ↓
2. Pilih jenis transaksi (masuk/keluar)
   ↓
3. Redirect ke halaman yang sama dengan query parameter
   ↓
4. Form transaksi muncul dengan jenis terkunci
   ↓
5. Isi detail barang dan tambahkan ke keranjang
   ↓
6. Ulangi langkah 5 untuk menambah item lain (opsional)
   ↓
7. Proses semua transaksi dalam keranjang
   ↓
8. Data tersimpan ke database dan keranjang dikosongkan
```

## File yang Dimodifikasi

### 1. Controller: `TransaksiStokController.php`

**Method Baru:**

-   `pilihJenisTransaksi()` - Handle pilihan jenis transaksi
-   `addToCart()` - Tambah item ke session cart
-   `removeFromCart()` - Hapus item dari cart
-   `clearCart()` - Kosongkan seluruh cart
-   `processTransaction()` - Proses semua transaksi dalam cart

**Method yang Dimodifikasi:**

-   `formTransaksiStok()` - Menambahkan support untuk query parameter dan session cart
-   `transactionCreate()` - Diubah untuk memproses multiple items dari cart

### 2. Routes: `web.php`

**Route Baru:**

```php
Route::post('/pilih-jenis', 'pilihJenisTransaksi')->name('stok.pilih-jenis');
Route::post('/add-to-cart', 'addToCart')->name('stok.add-to-cart');
Route::delete('/remove-from-cart/{itemKey}', 'removeFromCart')->name('stok.remove-from-cart');
Route::delete('/clear-cart', 'clearCart')->name('stok.clear-cart');
Route::post('/process-transaction', 'processTransaction')->name('stok.process');
```

### 3. View: `form-transaksi.blade.php`

**Perubahan Utama:**

-   Form pilih jenis transaksi dengan disabled state
-   Form transaksi hanya muncul jika jenis sudah dipilih
-   Field pemasok conditional berdasarkan jenis transaksi
-   Keranjang transaksi dengan looping items dari session
-   Tombol hapus individual dan kosongkan keranjang

### 4. JavaScript: `transaksi-stok.js`

**Fitur:**

-   Form validation
-   Loading indicators
-   Auto-focus management
-   Confirm dialogs untuk delete

## Session Structure

**Key:** `transaction_cart`

**Structure:**

```php
[
    'barang_id_pemasok_id' => [
        'barang_id' => 1,
        'barang_kode' => 'BRG001',
        'barang_nama' => 'Nama Barang',
        'barang_harga' => 50000,
        'pemasok_id' => 1, // nullable
        'pemasok_nama' => 'Nama Pemasok', // nullable
        'jumlah' => 10,
        'jenis_transaksi' => 'masuk'
    ]
]
```

## Validasi

### Form Pilih Jenis Transaksi

-   `jenisTransaksi`: required, in:masuk,keluar

### Form Add to Cart

-   `barang`: required, exists:tb_barang,id
-   `pemasok`: nullable, exists:tb_pemasok,id (required jika jenis=masuk)
-   `jumlahBarang`: required, numeric, min:1
-   Validasi stok untuk transaksi keluar
-   Validasi total quantity dalam cart untuk transaksi keluar

## Database Changes

Tidak ada perubahan database schema. Sistem menggunakan tabel yang sudah ada:

-   `tb_stok_transaksi`
-   `tb_barang`
-   `tb_pemasok`
-   `users`
-   `tb_notifikasi`

## Security Considerations

1. **CSRF Protection**: Semua form menggunakan `@csrf`
2. **Input Validation**: Semua input divalidasi sesuai aturan bisnis
3. **Authorization**: Route dilindungi middleware role `Op-Gudang|Owner`
4. **Session Security**: Cart data di-store dalam session yang aman
5. **SQL Injection**: Menggunakan Eloquent ORM yang aman

## Testing Checklist

-   [ ] Pilih jenis transaksi masuk
-   [ ] Pilih jenis transaksi keluar
-   [ ] Form pemasok muncul untuk transaksi masuk
-   [ ] Form pemasok tidak muncul untuk transaksi keluar
-   [ ] Validasi pemasok wajib untuk transaksi masuk
-   [ ] Tambah barang ke keranjang
-   [ ] Tambah barang yang sama (quantity bertambah)
-   [ ] Hapus item individual dari keranjang
-   [ ] Kosongkan seluruh keranjang
-   [ ] Proses transaksi (simpan ke database)
-   [ ] Validasi stok untuk transaksi keluar
-   [ ] Update stok barang setelah transaksi
-   [ ] Notifikasi dibuat setelah transaksi
-   [ ] Session keranjang dibersihkan setelah berhasil

## Error Handling

-   **Cart kosong**: Pesan error jika coba proses transaksi dengan cart kosong
-   **Stok tidak cukup**: Validasi stok untuk transaksi keluar
-   **Item tidak ditemukan**: Error jika coba hapus item yang tidak ada
-   **Jenis transaksi invalid**: Validasi jenis transaksi
-   **Database error**: Rollback transaction jika ada error

## Performance Optimization

-   **Caching**: Data barang dan pemasok di-cache selama 60 detik
-   **Lazy Loading**: Relationship loading hanya ketika diperlukan
-   **Session Storage**: Cart data disimpan di session, bukan database
-   **Bulk Insert**: Semua transaksi dalam cart diproses dalam satu batch

## Future Enhancements

1. **Bulk Import**: Upload Excel untuk multiple transaksi
2. **Batch Processing**: Queue processing untuk transaksi besar
3. **Audit Trail**: Log semua perubahan transaksi
4. **Email Notification**: Email otomatis untuk approval
5. **Barcode Scanner**: Integrasi scanner untuk input barang
6. **Real-time Stock**: WebSocket untuk update stok real-time
