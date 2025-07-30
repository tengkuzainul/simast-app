# Dokumentasi Fitur Cetak Faktur

## Overview

Fitur cetak faktur memungkinkan user untuk mencetak faktur profesional berdasarkan pemasok tertentu. Faktur mencakup semua transaksi masuk dari pemasok yang dipilih, diurutkan berdasarkan kode transaksi.

## Fitur Utama

### 1. **Select Option di Index Page**

-   Dropdown select untuk memilih pemasok
-   Menampilkan informasi: `Nama Pemasok - Kode Transaksi - Tanggal - Jumlah Transaksi`
-   Data diurutkan berdasarkan kode transaksi
-   Hanya menampilkan pemasok yang memiliki transaksi masuk

### 2. **Halaman Faktur Profesional**

-   **Header perusahaan** dengan logo dan informasi SIMAST
-   **Informasi pemasok** lengkap dengan alamat dan telepon
-   **Detail faktur** dengan nomor faktur otomatis
-   **Tabel transaksi** lengkap dengan semua data penting
-   **Ringkasan statistik** dan total nilai
-   **Section tanda tangan** untuk validasi
-   **Tombol print** dengan posisi fixed di kanan atas

### 3. **Format Nomor Faktur**

```
INV-{KODE_PEMASOK}-{YYYYMMDD}-{SEQUENCE}
Contoh: INV-SUP001-20250730-001
```

## File Structure

```
📁 resources/views/transaksi-stok/
├── 📄 index.blade.php (Updated dengan select faktur)
└── 📄 faktur.blade.php (New - Halaman faktur profesional)

📁 app/Http/Controllers/ManjamenStok/
└── 📄 TransaksiStokController.php (Added generateFaktur method)

📁 public/assets/css/
└── 📄 faktur.css (New - Styles untuk print dan responsive)

📁 routes/
└── 📄 web.php (Added faktur route)
```

## Controller Method

### `generateFaktur(Request $request)`

**Fungsi:**

-   Validasi pemasok_id
-   Ambil data pemasok
-   Query semua transaksi masuk dari pemasok
-   Calculate totals (items, quantity, value)
-   Generate nomor faktur otomatis
-   Return view dengan data lengkap

**Parameters:**

```php
$request->validate([
    'pemasok_id' => 'required|exists:tb_pemasok,id'
]);
```

**Return Data:**

```php
[
    'pemasok' => $pemasok,
    'transaksis' => $transaksis,
    'nomorFaktur' => $nomorFaktur,
    'totalItems' => $totalItems,
    'totalQuantity' => $totalQuantity,
    'totalValue' => $totalValue,
    'tanggalCetak' => now(),
]
```

## View Components

### 1. **Invoice Header**

-   Gradient background (#667eea ke #764ba2)
-   Logo perusahaan (Font Awesome warehouse icon)
-   Informasi SIMAST
-   Nomor faktur dan tanggal

### 2. **Supplier Information Card**

-   Nama pemasok
-   Kode pemasok
-   Alamat (jika ada)
-   Telepon (jika ada)

### 3. **Invoice Details Box**

-   Nomor faktur
-   Tanggal cetak
-   Total transaksi
-   Periode transaksi

### 4. **Transaction Table**

| No  | Kode Transaksi | Kode Barang | Nama Barang | Jumlah | Harga Satuan | Subtotal     | Status    | Tanggal  |
| --- | -------------- | ----------- | ----------- | ------ | ------------ | ------------ | --------- | -------- |
| 1   | TRX20250730001 | BRG001      | Nama Barang | 100    | Rp 50,000    | Rp 5,000,000 | Disetujui | 30/07/25 |

### 5. **Statistics Summary**

-   Total Transaksi (count)
-   Total Quantity (sum)
-   Total Disetujui (count)

### 6. **Invoice Total**

-   Subtotal
-   PPN 11%
-   Grand Total

### 7. **Signature Section**

-   Pemasok
-   Operator Gudang
-   Manager

## CSS Features

### Print Styles (`@media print`)

-   Hide `.no-print` elements
-   Adjust font sizes untuk print
-   Preserve background colors
-   Remove shadows dan animations
-   Page break handling

### Screen Styles (`@media screen`)

-   Responsive design
-   Hover effects
-   Animation pada print button
-   Better spacing untuk viewing

### Mobile Responsive (`@media max-width: 768px`)

-   Stack layout untuk mobile
-   Smaller font sizes
-   Flexible signature section
-   Repositioned print button

## JavaScript Features

### Print Functionality

```javascript
// Print button event
button.onclick = function () {
    window.print();
};

// Print event listeners
window.addEventListener("beforeprint", function () {
    console.log("Preparing to print...");
});

window.addEventListener("afterprint", function () {
    console.log("Print completed.");
});
```

### Auto-focus

-   Print button auto-focus saat halaman load
-   Better keyboard navigation

## Security & Validation

### ✅ **Input Validation**

-   Required pemasok_id
-   Exists validation untuk pemasok
-   Check transaksi availability

### ✅ **Business Logic Validation**

-   Hanya transaksi masuk yang ditampilkan
-   Data diurutkan berdasarkan kode transaksi
-   Handle empty transactions

### ✅ **Access Control**

-   Route dilindungi middleware role
-   CSRF protection pada form

## Performance Optimizations

### ✅ **Database Queries**

-   Single query dengan eager loading
-   Efficient groupBy untuk dropdown
-   Index pada field yang sering diquery

### ✅ **Frontend Performance**

-   CDN untuk Bootstrap dan FontAwesome
-   Minified CSS untuk production
-   Optimized print styles

## Usage Flow

```
1. User buka halaman index transaksi
   ↓
2. Pilih pemasok dari dropdown "Cetak Faktur"
   ↓
3. Klik tombol "Cetak Faktur"
   ↓
4. Redirect ke halaman faktur profesional
   ↓
5. Review faktur di layar
   ↓
6. Klik tombol "Cetak Faktur" (fixed position)
   ↓
7. Browser print dialog terbuka
   ↓
8. Print atau save sebagai PDF
```

## Error Handling

### Validation Errors

-   **Pemasok tidak dipilih**: Required validation error
-   **Pemasok tidak valid**: Exists validation error
-   **Tidak ada transaksi**: Redirect dengan error message

### Business Logic Errors

-   **Empty transactions**: Pesan "Tidak ada transaksi masuk"
-   **Missing supplier data**: Fallback ke data minimal
-   **Calculation errors**: Default ke 0 dengan fallback

## Testing Checklist

### ✅ **Functional Testing**

-   [ ] Dropdown pemasok menampilkan data yang benar
-   [ ] Filter hanya pemasok dengan transaksi masuk
-   [ ] Nomor faktur generate dengan benar
-   [ ] Semua data transaksi ditampilkan lengkap
-   [ ] Perhitungan total akurat
-   [ ] Print functionality bekerja
-   [ ] Responsive design di berbagai device

### ✅ **UI/UX Testing**

-   [ ] Layout professional dan clean
-   [ ] Print preview sesuai dengan tampilan layar
-   [ ] Mobile responsive
-   [ ] Loading states
-   [ ] Error messages informatif

### ✅ **Print Testing**

-   [ ] Print to PDF berfungsi
-   [ ] Print ke printer fisik
-   [ ] Page breaks yang tepat
-   [ ] Colors preserved dalam print
-   [ ] Fonts readable dalam print

## Browser Compatibility

### ✅ **Supported Browsers**

-   Chrome 90+ ✅
-   Firefox 88+ ✅
-   Safari 14+ ✅
-   Edge 90+ ✅

### ✅ **Print Support**

-   PDF generation ✅
-   Physical printer ✅
-   Print preview ✅
-   Page orientation handling ✅

## Future Enhancements

### 1. **Export Options**

-   Export ke Excel
-   Export ke Word document
-   Email faktur otomatis

### 2. **Template Customization**

-   Multiple template designs
-   Company branding customization
-   Custom field additions

### 3. **Batch Processing**

-   Multiple pemasok selection
-   Date range filtering
-   Bulk faktur generation

### 4. **Digital Signature**

-   Digital signature integration
-   QR code untuk verification
-   Blockchain-based authenticity

### 5. **Advanced Features**

-   Faktur scheduling
-   Payment tracking integration
-   Automatic follow-up reminders

## API Endpoints

### Generate Faktur

```
GET /manajemen-stok/faktur?pemasok_id={id}
```

**Parameters:**

-   `pemasok_id` (required): ID pemasok

**Response:**

-   HTML faktur page
-   404 jika pemasok tidak ditemukan
-   Redirect dengan error jika tidak ada transaksi

## Performance Metrics

### Target Performance

-   **Page Load**: < 2 seconds
-   **Print Preparation**: < 1 second
-   **PDF Generation**: < 3 seconds
-   **Database Query**: < 500ms

### Monitoring

-   Query execution time
-   Page load metrics
-   Print success rate
-   User engagement tracking
