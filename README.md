[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5aa02afb8707418cb0a219a08ea489cb)](https://www.codacy.com/app/yunpengn/CS1101S-DG-Website?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=yunpengn/CS1101S-DG-Website&amp;utm_campaign=Badge_Grade)

# NUS CS1101S Discussion Group Website

__[CS1101S Programming Methodology](https://comp.nus.edu.sg/~cs1101s/) (in JavaScript)<br>
AY2017/2018 Semester 1<br>
[School of Computing](https://comp.nus.edu.sg/)<br>
[National University of Singapore](https://www.nus.edu.sg/)__

### Visit this DG website at [here](https://cs1101s.azurewebsites.net/).

#### Discussion Group taught by Avenger [Niu Yunpeng](https://comp.nus.edu.sg/~e0134079/).

## Main Features
1. Support file upload / delete for admin users;
2. Support file download (only after login in) for other users;
3. Support common user management functions for admin users;
4. Support a simple but powerful online text editor (credit to [Ace Editor](https://ace.c9.io/))

## Implementation
PHP was adapted as the server-side language, simple HTML / CSS / JavaScript was adapted as the client-side languages, Bootstrap was adapted as the front-end framework.

### Inspiration
More and more web frameworks have been developed nowadays. But, why don't we just go back and see what we can do with only the most basic system functions? What kind of magic will happen?

## How to Use
- Notice that in the latest release, we have switched from mySQLi to PDO (PHP Database Object). That means we have adapted to the OOP style rather than procedural style. Also, this provides a unified interface in case that users may be using different database, like mySQL, PostGreSQL, etc.
- In the future, there are two important updates: 1) Update from PHP 5.6 to PHP 7; 2) Fully adapt OOP style programming.

### Set-up of Database (using mySQL)
- Overview<br>
We need two tables in a single database. Below, assume that we have created the database called 'cs1101s'.<br>
Therefore, you need to change the connection variables in config.php

- Create _users_ Table<br>
To create the table of users, please type in the following SQL command:
```
CREATE TABLE users (
    id int AUTO_INCREMENT,
    created_at TIMESTAMP,
    user_type int NOT NULL,
    username varchar(50) UNIQUE NOT NULL,
    password varchar(80) NOT NULL,
    PRIMARY KEY(id)
);
```
To create an admin user, please type in the following SQL command:
```
INSERT INTO users (user_type, username, password) VALUES (0, "Jack", "123456");
```
To create a student user (normal user), please type in the following SQL command:
```
INSERT INTO users (user_type, username, password) VALUES (1, "Lily", "987654");
```

- Create _files_ Table<br>
To create the table of files, please type in the following SQL command:
```
CREATE TABLE files (
    id int AUTO_INCREMENT,
    uploaded_at TIMESTAMP,
    file_name varchar(100) NOT NULL,
    author varchar(100),
    description varchar(500),
    file_path varchar(200) NOT NULL,
    PRIMARY KEY(id)
);
```

- Visualization Tool<br>
We recommend you to use [phpMyAdmin](https://www.phpmyadmin.net/).

### Set-up of Database (using Microsoft SQL Server)
- Overview<br>
We need two tables in a single database. Below, assume that we have created the database called 'cs1101s'.<br>
Therefore, you need to change the connection variables in config.php

- Create _users_ Table<br>
To create the table of users, please type in the following SQL command:
```
CREATE TABLE users (
    id int IDENTITY(1, 1) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_type int NOT NULL,
    username varchar(50) UNQIUE NOT NULL,
    password varchar(80) NOT NULL,
    PRIMARY KEY(id)
);
```
To create an admin user, please type in the following SQL command:
```
INSERT INTO dbo.users (user_type, username, password) VALUES (0, 'Jack', '123456');
```
To create a student user (normal user), please type in the following SQL command:
```
INSERT INTO dbo.users (user_type, username, password) VALUES (1, 'Lily', '987654');
```

- Create _files_ Table<br>
To create the table of files, please type in the following SQL command:
```
CREATE TABLE files (
    id int IDENTITY(1, 1) NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    file_name varchar(100) NOT NULL,
    author varchar(100),
    description varchar(500),
    file_path varchar(200) NOT NULL,
    PRIMARY KEY(id)
);
```

- Visualization Tool<br>
We recommend you to use [SQL Database Studio](https://www.sqldatabasestudio.com/).

## Configuration of database connection
- Change the file name of "config.example.php" into "config.php"
- Change the default username and password.
- Notice, you may want to move the "config.php" out of the wwwroot repository due to security reason, in which case you should change line 3 in "useful.php" to pointing to the correct position. 

## About maximum file size
- Open your php.ini, change the value of upload_max_filesize (the default value is 2M, recommend to set it to be 5M).
- You may also need to change the value of post_max_size in php.ini as well (the default value is 8M).
- Remember to re-start the server to make the changes take effect.

## Notice
This project is under [GNU Public License (GPL) 3.0](http://www.gnu.org/licenses/gpl-3.0.en.html).
