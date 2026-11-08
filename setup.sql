-- Terminate all connections to the database before dropping
SELECT pg_terminate_backend(pg_stat_activity.pid)
FROM pg_stat_activity
WHERE pg_stat_activity.datname = 'characters'
AND pid <> pg_backend_pid();

-- Drop the database and user if they exist
DROP DATABASE IF EXISTS characters;
DROP USER IF EXISTS slave;

-- Create a new user with password
CREATE USER slave WITH PASSWORD '';

-- Create a new database owned by slave
CREATE DATABASE characters OWNER slave;

-- Connect to the characters database
\c characters

-- Create the characters table (NO trailing comma!)
CREATE TABLE characters (
    id SERIAL PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(500)
);

-- Grant privileges on the schema and tables to slave
GRANT ALL PRIVILEGES ON SCHEMA public TO slave;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO slave;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO slave;

-- Insert Aizen and Madara
INSERT INTO characters (type, title, description, image) VALUES
('aura', 'Aizen Sosuke', 'Everything you do is just a part of my plan.', 'aizen.jpg'),
('aura', 'Madara Uchiha', 'Wanna dance?..', 'madara.jpg'),
('aura', 'Askelad', 'Justice... Vengeance... Whatever.', 'askelad.jpg'),
('aura', 'L', 'I am L.', 'l.jpg'),
('aura', 'Gojo Satoru', 'I am the strongest one.', 'gojo.jpg'),
('aura', 'Sukuna', 'I am king of curses, Sukuna!', 'sukuna.jpg'),
('aura', 'Toji', 'I need to gamble.', 'toji.jpg'),

('bum',  'Temari', 'Sacrifice is an inevitable part of missions... Didnt you receive emotion training?', 'temari.jpg'),
('bum',  'Megumi', 'I am a man of potential, I am a bum.', 'megumi.jpg'),
('bum',  'Sakura Haruna', 'I am useless', 'sakura.jpg'),
('bum',  'Sam Altman', 'Do you have a spare pair of ram', 'sam_altman.jpg'),
('bum',  'Jeffrey Epstein', 'Do you have kids?..', 'kids_lover.jpg'),
('bum',  'Rust', 'I am everywhere, I will rewrite you brain', 'rust_prog.jpg'),
('bum',  'Maki', 'I am like Toji, uuuuu', 'maki.jpg')
;



-- Verify the data was inserted
SELECT * FROM characters;

\echo 'Database setup completed successfully!'
