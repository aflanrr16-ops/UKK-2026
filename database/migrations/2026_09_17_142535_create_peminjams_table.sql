-- create_peminjams_table

CREATE TABLE IF NOT EXISTS `peminjam` (
    id_peminjam        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_users            INT UNSIGNED NOT NULL,
    nis                VARCHAR(20) NOT NULL,
    nama_peminjam      VARCHAR(255) NOT NULL,
    kelas              VARCHAR(10) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL

    CONSTRAINT fk_siswa_user FOREIGN KEY (id_usesr)
    REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
