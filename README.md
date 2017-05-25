# NUS CS1101S Discussion Group Website

__[CS1101S Programming Methodology](https://comp.nus.edu.sg/~cs1101s/) (in JavaScript)<br>
AY2017/2018 Semester 1<br>
[School of Computing](https://comp.nus.edu.sg/)<br>
[National University of Singapore](https://www.nus.edu.sg/)__

### Visit this DG website at [here](http://cs1101s-dg.hol.es/).

#### Discussion Group taught by Avenger [Niu Yunpeng](https://comp.nus.edu.sg/~e0134079/).

## Main Features
1. Support file upload / delete for admin users;
2. Support file download (only after login in) for other users.

## Implementation
PHP was adapted as the server-side language, simple HTML / CSS / JavaScript was adapted as the client-side languages, Bootstrap was adapted as the front-end framework.

## How to Use
### Set-up of Database
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
    username varchar(50) NOT NULL,
    password varchar(80) NOT NULL,
    PRIMARY KEY(Id)
);
```
To create an admin user, please type in the following SQL command:
```
INSERT INTO Users (UserType, Username, Password) VALUES (0, "Jack", "123456");
```
To create a student user (normal user), please type in the following SQL command:
```
INSERT INTO Users (UserType, Username, Password) VALUES (1, "Lily", "987654");
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
    PRIMARY KEY(Id)
);
```

## Notice
This project is under [GNU Public License (GPL) 3.0](http://www.gnu.org/licenses/gpl-3.0.en.html).
