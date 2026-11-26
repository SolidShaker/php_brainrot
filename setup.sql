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

-- Create the types table FIRST (parent table)
CREATE TABLE characters_types (
    id SERIAL PRIMARY KEY,
    type VARCHAR(50) NOT NULL UNIQUE   -- removed trailing semicolon inside parens, added UNIQUE
);

-- Create the characters table with a FOREIGN KEY to characters_types
CREATE TABLE characters (
    id SERIAL PRIMARY KEY,
    type_id INTEGER NOT NULL REFERENCES characters_types(id) ON DELETE RESTRICT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(500)
);

-- Grant privileges on the schema and tables to slave
GRANT ALL PRIVILEGES ON SCHEMA public TO slave;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO slave;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO slave;

-- Insert the distinct types first
INSERT INTO characters_types (type) VALUES
('aura'),
('bum');

-- Insert characters, referencing the type by its id
INSERT INTO characters (type_id, title, description, image) VALUES
(1, 'Aizen Sosuke',   'Everything you do is just a part of my plan.', '/images/aizen.jpg'),
(1, 'Madara Uchiha',  'Wanna dance?..', '/images/madara.jpg'),
(1, 'Askelad',        'Justice... Vengeance... Whatever.', '/images/askelad.jpg'),
(1, 'L',              'I am L.', '/images/l.jpg'),
(1, 'Gojo Satoru',    'I am the strongest one.', '/images/gojo.jpg'),
(1, 'Sukuna',         'I am king of curses, Sukuna!', '/images/sukuna.jpg'),
(1, 'Toji',           'I need to gamble.', '/images/toji.jpg'),

(2, 'Temari',         'Sacrifice is an inevitable part of missions... Didnt you receive emotion training?', '/images/temari.jpg'),
(2, 'Megumi',         'I am a man of potential, I am a bum.', '/images/megumi.jpg'),
(2, 'Sakura Haruna',  'I am useless', '/images/sakura.jpg'),
(2, 'Sam Altman',     'Do you have a spare pair of ram sticks in your ass', '/images/sam_altman.jpg'),
(2, 'Jeffrey Epstein', 'Do you have kids?..', '/images/kids_lover.jpg'),
(2, 'Rust',           'I am everywhere, I will rewrite you brain', '/images/rust_prog.jpg'),
(2, 'Maki',           'I am like Toji, uuuuu', '/images/maki.jpg');

-- Verify the data
SELECT c.id, t.type, c.title, c.description, c.image
FROM characters c
JOIN characters_types t ON t.id = c.type_id
ORDER BY c.id;

\echo 'Database setup completed successfully!'
