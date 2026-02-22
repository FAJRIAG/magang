@php
    $translations = [
        'Employees' => 'Karyawan',
        'Add New Employee' => 'Tambah Karyawan Baru',
        'Name' => 'Nama',
        'Link User Account (Optional)' => 'Hubungkan Akun Pengguna (Opsional)',
        'None' => 'Tidak Ada',
        'Add Employee' => 'Tambah Karyawan',
        'Employee List' => 'Daftar Karyawan',
        'Actions' => 'Aksi',
        'Edit' => 'Ubah',
        'Delete' => 'Hapus',
        'Linked Account' => 'Akun Terhubung',
        'Not Linked' => 'Tidak Terhubung',
        'Manage Tasks' => 'Kelola Tugas',
        'Add New Task' => 'Tambah Tugas Baru',
        'Title' => 'Judul',
        'Points' => 'Poin',
        'Description' => 'Deskripsi',
        'Assign' => 'Tugaskan',
        'Create Task' => 'Buat Tugas',
        'Edit Task' => 'Ubah Tugas',
        'Approve' => 'Setujui',
        'Reject' => 'Tolak',
        'Pending Submissions' => 'Pengajuan Tertunda',
        'Employee' => 'Karyawan',
        'Task' => 'Tugas',
        'Status' => 'Status',
        'Submitted At' => 'Diajukan Pada',
        'Devices' => 'Perangkat',
        'Add New Device' => 'Tambah Perangkat Baru',
        'Device Name' => 'Nama Perangkat',
        'Secret Key' => 'Kunci Rahasia',
        'Generate New Secret' => 'Buat Kunci Baru',
        'Settings' => 'Pengaturan',
        'Configuration' => 'Konfigurasi',
        'Key' => 'Kunci',
        'Value' => 'Nilai',
        'Save' => 'Simpan',
        'Update' => 'Perbarui',
        'Cancel' => 'Batal',
        'Confirm' => 'Konfirmasi',
        'Are you sure?' => 'Apakah Anda yakin?',
        'Success message' => 'Berhasil',
    ];

    function __($text)
    {
        global $translations;
        return $translations[$text] ?? $text;
    }
@endphp