# SIDUKTANG - Sistem Informasi Manajemen Penduduk Pendatang

SIDUKTANG adalah sistem informasi berbasis web yang dirancang untuk mengelola data penduduk pendatang di suatu wilayah. Sistem ini bertujuan untuk memodernisasi dan mengefisiensikan proses pendataan, verifikasi, dan pelaporan data penduduk, serta menyediakan layanan surat-menyurat bagi penduduk yang terdaftar.

## Fitur Utama

-   **Otentikasi Pengguna:** Sistem *login* dan *register* yang aman untuk berbagai level pengguna.
-   **Manajemen Pengguna:**
    -   **Admin:** Memiliki hak akses penuh untuk mengelola semua data, termasuk verifikasi akun baru.
    -   **Kepala Lingkungan:** Dapat memverifikasi data penduduk pendatang yang masuk ke wilayahnya dan menyetujui pengajuan surat.
    -   **Penanggung Jawab:** Dapat mendaftarkan dan mengelola data penduduk pendatang yang menjadi tanggungannya.
-   **Manajemen Data Penduduk:**
    -   Pendaftaran penduduk pendatang baru dengan data yang lengkap, termasuk data diri, alamat asal, alamat sekarang, dan foto KTP.
    -   Proses verifikasi data penduduk oleh Kepala Lingkungan.
    -   Pencatatan penduduk yang keluar atau pindah.
-   **Layanan Surat:**
    -   Pengajuan berbagai jenis surat oleh penduduk melalui penanggung jawab, seperti:
        -   Surat Keterangan Domisili
        -   Surat Pengantar Umum
        -   Surat Pengantar SKCK
        -   Surat Keterangan Kehilangan Lokal
        -   Surat Keterangan Untuk Sekolah Anak
    -   Proses persetujuan pengajuan surat oleh Kepala Lingkungan.
    -   *Generate* dan unduh surat dalam format PDF.
-   **Pelaporan:**
    -   *Dashboard* dengan statistik ringkas mengenai jumlah akun, penduduk, dan pengajuan surat.
    -   Fitur *export* data penduduk dan layanan surat ke dalam format CSV dan Excel.
    -   Peta sebaran lokasi penduduk.

## Teknologi yang Digunakan

-   **Backend:** Laravel 11
-   **Frontend:**
    -   Blade
    -   Livewire
    -   Tailwind CSS
    -   Font Awesome
    -   Flowbite
-   **Database:** MySQL
-   **Pustaka Lainnya:**
    -   Spatie Laravel PDF
    -   Maatwebsite Excel

## Peran Pengguna (Roles)

1.  **Admin:**
    -   Memverifikasi akun baru (Kepala Lingkungan dan Penanggung Jawab).
    -   Mengelola semua data pengguna dan data master.
    -   Melihat semua data penduduk dan laporan.

2.  **Kepala Lingkungan:**
    -   Memverifikasi data penduduk pendatang baru yang didaftarkan oleh Penanggung Jawab.
    -   Menyetujui atau menolak pengajuan surat dari penduduk.
    -   Melihat data penduduk dan laporan di wilayahnya.

3.  **Penanggung Jawab:**
    -   Mendaftarkan data penduduk pendatang yang menjadi tanggungannya.
    -   Mengajukan surat untuk penduduk yang didaftarkan.
    -   Melihat data penduduk yang didaftarkannya.

## Alur Kerja Sistem

1.  **Registrasi Akun:** Calon pengguna (Kepala Lingkungan atau Penanggung Jawab) melakukan registrasi.
2.  **Verifikasi Akun:** Admin memverifikasi dan menyetujui akun baru. *Password* sementara akan dikirimkan ke *email* pendaftar.
3.  **Login Pertama:** Pengguna *login* menggunakan *username* dan *password* sementara, kemudian sistem akan mewajibkan pengguna untuk mengubah *password* dan mengatur lokasi mereka.
4.  **Pendaftaran Penduduk:** Penanggung Jawab mendaftarkan data penduduk pendatang baru.
5.  **Verifikasi Penduduk:** Kepala Lingkungan memverifikasi data penduduk baru.
6.  **Pengajuan Surat:** Penanggung Jawab dapat mengajukan surat untuk penduduk yang sudah terverifikasi.
7.  **Persetujuan Surat:** Kepala Lingkungan menyetujui atau menolak pengajuan surat.
8.  **Cetak Surat:** Penanggung Jawab dapat mengunduh surat yang telah disetujui dalam format PDF.
