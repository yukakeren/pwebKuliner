-- Create the database with proper syntax
CREATE DATABASE IF NOT EXISTS kya_kya
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

-- Select the database
USE kya_kya;

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    people VARCHAR(10) NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    message TEXT,
    created_at DATETIME NOT NULL
);

-- Optional: Add an index on common search fields
CREATE idx_booking_date ON bookings(reservation_date);