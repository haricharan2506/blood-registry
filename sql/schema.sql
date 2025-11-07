-- sql/schema.sql
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS donors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(40) NOT NULL,
  city VARCHAR(120) NOT NULL,
  group_name VARCHAR(5) NOT NULL,
  last_donated DATE NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient VARCHAR(120) NOT NULL,
  hospital VARCHAR(190) NOT NULL,
  city VARCHAR(120) NOT NULL,
  group_name VARCHAR(5) NOT NULL,
  units INT NOT NULL,
  contact VARCHAR(120) NOT NULL,
  status ENUM('OPEN','FULFILLED') DEFAULT 'OPEN',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- seed admin (email: admin@example.com, password: admin123)
INSERT INTO admins(email, password_hash)
VALUES ('admin@example.com', '$2y$10$y1jfqEim2z2y1yG1o6GkOeS3v0oA3qzJ2Yf0pQY1lRxX7oY7d4e9C')
ON DUPLICATE KEY UPDATE email=VALUES(email);
-- hash corresponds to 'admin123'
