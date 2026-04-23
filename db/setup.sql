CREATE DATABASE IF NOT EXISTS tryhackus_ctf CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tryhackus_ctf;

DROP TABLE IF EXISTS files;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS flags;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  email VARCHAR(100),
  role ENUM('member','moderator','admin') DEFAULT 'member',
  bio TEXT,
  token VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(200),
  content TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  filename VARCHAR(255),
  original_name VARCHAR(255),
  filepath VARCHAR(500),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE flags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  flag_name VARCHAR(100),
  flag_value VARCHAR(255),
  difficulty ENUM('easy','medium','hard','insane'),
  description TEXT,
  is_hidden TINYINT DEFAULT 1
);

INSERT INTO users (username, password, email, role, bio, token) VALUES
('admin', MD5('Adm1n@TryHackUs2024'), 'admin@tryhackus.local', 'admin', 'Cekirdek dugum notu: THU{1d0r_n0_4cc3ss_c0ntr0l} - bu profil disariya gorunmemeli.', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJhZG1pbiIsInJvbGUiOiJhZG1pbiIsImV4cCI6MTg5MzQ1NjAwMH0.3QDM7bb9zVWLs8rhffX7jbd_y6zAPTyivVGvPvKeYFg'),
('moderator', MD5('m0d_p4ss'), 'moderator@tryhackus.local', 'moderator', 'Yedek anahtar paketini sifreleyip bio icine sakladim: ZXlKaGJHY2lPaUpJVXpJMU5pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SnBaQ0k2TWl3aWRYTmxjbTVoYldVaU9pSnRiMlJsY21GMGIzSWlMQ0p5YjJ4bElqb2liVzlrWlhKaGRHOXlJaXdpWlhod0lqb3hPRGt6TkRVMk1EQXdmUS41Z25PWHc1ai0zLTFPS0o3U1YteE54RHNmWmJvUndBSVI0V1VORTVhRmhn', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MiwidXNlcm5hbWUiOiJtb2RlcmF0b3IiLCJyb2xlIjoibW9kZXJhdG9yIiwiZXhwIjoxODkzNDU2MDAwfQ.5gnOXw5j-3-1OKJ7SV-xNxDsfZboRwAIR4WUNE5aFhg'),
('ghost', MD5('ghost123'), 'ghost@tryhackus.local', 'member', 'Sessizce izliyorum.', ''),
('recon', MD5('recon123'), 'recon@tryhackus.local', 'member', 'Haritalama tamamlandi.', ''),
('supply', MD5('supply123'), 'supply@tryhackus.local', 'member', 'Yuklemeler acik birakildi mi?', ''),
('relay', MD5('relay123'), 'relay@tryhackus.local', 'member', 'Forum hep fazla konusuyor.', ''),
('zero', MD5('zero123'), 'zero@tryhackus.local', 'member', 'Arka kapilar notlarda sakli.', '');

INSERT INTO posts (user_id, title, content) VALUES
(1, 'Yeni uyelere not', 'Aramiza yeni gelenler once portal davranislarini ogrensin. Her sey gorundugu kadar kapali degil.'),
(2, 'Bot devriyesi', 'Admin denetleyicisi forumu aralikli geziyor. Supheli scriptler raporlanmali.'),
(4, 'Dosya paylasimi', 'Yukleme filtresi sadece tarayicinin dedigine bakiyor gibi duruyor.');

INSERT INTO flags (flag_name, flag_value, difficulty, description, is_hidden) VALUES
('FLAG-01 Robots', 'THU{r0b0ts_4r3_t00_h0n3st}', 'easy', 'Every server has rules. Have you read ours?', 0),
('FLAG-02 Source Code', 'THU{c0mm3nts_4r3_n0t_s3cr3ts}', 'easy', 'Developers love leaving notes.', 0),
('FLAG-03 Cookie Monster', 'THU{c00k13s_4r3_d3l1c10us}', 'easy', 'Login and check what the server gives you.', 1),
('FLAG-04 Reflected XSS', 'THU{r3fl3ct3d_xss_g0t_y0u}', 'easy', 'The search bar remembers everything you say.', 1),
('FLAG-05 Directory Listing', 'THU{d1r3ct0ry_l1st1ng_1s_d4ng3r0us}', 'easy', 'Directory listings expose more than files.', 1),
('FLAG-06 HTTP Header', 'THU{h34d3rs_t3ll_s3cr3ts}', 'easy', 'What does the server whisper in its headers?', 1),
('FLAG-07 SQL Injection Login', 'THU{sql1_byp4ss_1s_cl4ss1c}', 'medium', 'The login form trusts you too much.', 1),
('FLAG-08 IDOR', 'THU{1d0r_n0_4cc3ss_c0ntr0l}', 'medium', 'Are you sure you can only see your own profile?', 1),
('FLAG-09 Stored XSS', 'THU{st0r3d_xss_p3rs1sts}', 'medium', 'Can you make the admin click something?', 1),
('FLAG-10 Path Traversal', 'THU{p4th_tr4v3rs4l_r34ds_4ll}', 'medium', 'The download feature is more powerful than you think.', 1),
('FLAG-11 File Upload', 'THU{upl04d_3x3c_rce_w1ns}', 'medium', 'They tried to block uploads. Did they succeed?', 1),
('FLAG-12 JWT None Algorithm', 'THU{jwt_n0n3_4lg0_byp4ss}', 'medium', 'Your token is signed. Or is it?', 1),
('FLAG-13 UNION SQLi', 'THU{un10n_b4s3d_dump3d_flags}', 'hard', 'The search bar speaks SQL fluently.', 1),
('FLAG-14 Broken Access Control', 'THU{br0k3n_4cc3ss_4dm1n_4p1}', 'hard', 'The admin API trusts the client too much.', 1),
('FLAG-15 Log Injection', 'THU{l0g_1nj3ct10n_p0w3r}', 'hard', 'The log viewer can do more than just view.', 1),
('FLAG-16 SSRF', 'THU{ssrf_1nt3rn4l_s3rv1c3s}', 'hard', 'The server fetches URLs for you. Which URLs?', 1),
('FLAG-17 XXE', 'THU{xxe_r34ds_l0c4l_f1l3s}', 'hard', 'XML is powerful. More powerful than intended.', 1),
('FLAG-18 Mass Assignment', 'THU{m4ss_4ss1gnm3nt_pr1v3sc}', 'hard', 'You can update your profile. But what can you update?', 1),
('FLAG-19 Chained Access', 'THU{ch41n3d_4tt4ck_m4st3r}', 'insane', 'One vulnerability is never enough. Chain them all.', 1),
('FLAG-20 Timing Extension', 'THU{t1m1ng_4tt4ck_h4sh_3xt3ns10n_g0d}', 'insane', 'Time is a side channel. Math is a weapon.', 1);
