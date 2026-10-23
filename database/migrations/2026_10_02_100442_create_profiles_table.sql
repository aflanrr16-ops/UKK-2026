CREATE TABLE IF NOT EXISTS `profile` (
    `id_profile` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `id_user` INT UNSIGNED NOT NULL,
    `nama_lengkap` VARCHAR(255) NOT NULL,
    `nomor_telepon` VARCHAR(20) NULL,
    `kelas` VARCHAR(100) NULL,
    `alamat` TEXT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,

    CONSTRAINT `fk_profile_user` 
        FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;