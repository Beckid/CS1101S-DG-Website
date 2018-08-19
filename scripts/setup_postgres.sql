DROP DATABASE IF EXISTS cs1101s;
CREATE DATABASE cs1101s;

CREATE TABLE users (
    id int SERIAL PRIMARY KEY,
    created_at timestamp DEFAULT current_timestamp,
    user_type int NOT NULL,
    username varchar(50) UNQIUE NOT NULL,
    password varchar(80) NOT NULL
);

CREATE TABLE files (
    id int SERIAL PRIMARY KEY,
    uploaded_at timestamp DEFAULT current_timestamp,
    file_name varchar(100) NOT NULL,
    author varchar(100),
    description varchar(500),
    file_path varchar(200) NOT NULL
);
