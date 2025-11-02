-- Create database
CREATE DATABASE IF NOT EXISTS kamus_gaul;
USE kamus_gaul;

-- Create table for users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create table for words
CREATE TABLE IF NOT EXISTS words (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kata VARCHAR(100) NOT NULL,
    definisi TEXT NOT NULL,
    contoh TEXT NOT NULL,
    tags VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create indexes for better search performance
CREATE INDEX idx_kata ON words(kata);
CREATE INDEX idx_definisi ON words(definisi(255));
CREATE INDEX idx_tags ON words(tags);
CREATE INDEX idx_user_id ON words(user_id);

-- Create fulltext index for advanced search
ALTER TABLE words ADD FULLTEXT(kata, definisi, tags);

-- Insert admin user
INSERT INTO users (username, email, password, full_name) VALUES
('admin', 'admin@example.com', '$2y$10$WzTjY3aZq9pX5uR9dQpF0OZy7HjB3o5xMvG5tFQyY3RZC2KzYQb7K', 'Admin Gaul');

-- Insert kata-kata gaul
INSERT INTO words (kata, definisi, contoh, tags, user_id) VALUES
('Gaspol', 'Berarti langsung jalan atau lanjut tanpa ragu. Biasanya dipakai saat mau mulai sesuatu dengan semangat.', 'Udah siap? Gaspol aja bro!', 'semangat, aksi, motivasi', 1),
('Mager', 'Singkatan dari malas gerak. Dipakai saat seseorang merasa malas melakukan sesuatu.', 'Mau ke mall sih, tapi mager banget.', 'malas, santai', 1),
('Bucin', 'Singkatan dari budak cinta. Digunakan untuk menyebut seseorang yang terlalu tergila-gila pada pasangannya.', 'Dia rela dijemput jam 2 pagi, bucin banget sih.', 'romantis, hubungan, cinta', 1),
('Santuy', 'Berarti santai tapi dengan gaya gaul. Menunjukkan sikap tenang dan nggak panikan.', 'Udah santuy aja, nanti juga kelar.', 'santai, tenang, gaul', 1),
('Gabut', 'Kependekan dari gaji buta tapi sekarang artinya lagi nggak ada kerjaan.', 'Aku gabut nih, scrolling TikTok aja deh.', 'bosan, santai', 1),
('Receh', 'Digunakan untuk hal yang dianggap kecil, ringan, atau lucu tapi nggak terlalu penting.', 'Jokemu receh banget tapi aku ngakak.', 'humor, ringan', 1),
('Ciee', 'Ekspresi menggoda atau meledek seseorang yang sedang dekat dengan orang lain.', 'Ciee... yang lagi video call-an tiap malam.', 'godaan, lucu, cinta', 1),
('Flexing', 'Pamer harta atau pencapaian, biasanya di media sosial.', 'Dia flexing mobil baru di Instagram.', 'sosial media, pamer', 1),
('Skuy', 'Kata kebalikan dari yuk, artinya ajakan santai untuk melakukan sesuatu.', 'Skuy nongkrong di kafe baru.', 'ajak, santai, teman', 1),
('Healing', 'Istilah untuk menyebut kegiatan menenangkan diri dari stres.', 'Weekend ini aku mau ke pantai buat healing.', 'relaksasi, mental health', 1),
('Wibu', 'Sebutannya untuk orang yang sangat menyukai budaya Jepang, terutama anime.', 'Dia nonton anime tiap hari, wibu banget.', 'anime, jepang, fandom', 1),
('Nolep', 'Singkatan dari no life, untuk orang yang jarang bersosialisasi dan sibuk sendiri.', 'Dia di rumah mulu main game, nolep banget.', 'game, sosial', 1),
('Caper', 'Singkatan dari cari perhatian, biasanya untuk orang yang suka pamer atau ingin diperhatikan.', 'Dia upload story tiap jam, caper banget.', 'perhatian, sosial media', 1),
('Otw', 'Singkatan dari on the way, artinya sedang dalam perjalanan.', 'Otw ya, 5 menit lagi nyampe. (padahal masih di rumah)', 'perjalanan, komunikasi', 1),
('Gaskeun', 'Versi lain dari gas atau gaspol, artinya ayo lanjut atau jalan terus.', 'Udah siap semua? Gaskeun!', 'semangat, aksi, motivasi', 1);

-- Update null timestamps to current timestamp
UPDATE words SET created_at = NOW() WHERE created_at IS NULL;
UPDATE words SET updated_at = NOW() WHERE updated_at IS NULL;