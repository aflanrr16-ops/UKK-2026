-- create_roles_table
-- Daftar role yang bisa dipilih saat menambah user. Admin bisa menambah
-- role baru lewat halaman /admin/roles.

CREATE TABLE IF NOT EXISTS `roles` (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(50) NOT NULL UNIQUE,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Role bawaan, sesuai role yang sudah dipakai login multi-role.
INSERT INTO `roles` (name, created_at, updated_at)
SELECT * FROM (SELECT 'admin' AS name, NOW() AS created_at, NOW() AS updated_at) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE name = 'admin');

INSERT INTO `roles` (name, created_at, updated_at)
SELECT * FROM (SELECT 'staff' AS name, NOW() AS created_at, NOW() AS updated_at) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE name = 'staff');

INSERT INTO `roles` (name, created_at, updated_at)
SELECT * FROM (SELECT 'user' AS name, NOW() AS created_at, NOW() AS updated_at) AS tmp
WHERE NOT EXISTS (SELECT 1 FROM `roles` WHERE name = 'user');
