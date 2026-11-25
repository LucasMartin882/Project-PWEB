-- Active: 1792113655723@@127.0.0.1@3306@project_pweb_2026_k1
create DATABASE if not exists project_pweb_2026_k1;
use project_pweb_2026_k1;

create table if not exists categories(
  id int not null primary key AUTO_INCREMENT,
  name VARCHAR(100) not null,
  description text null,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table if not exists users(
  id int not null PRIMARY key AUTO_INCREMENT,
  username VARCHAR(50) not null UNIQUE,
  password VARCHAR(255) not null,
  name VARCHAR(255) not null,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 
create table if not exists news(
  id int not null PRIMARY key AUTO_INCREMENT,
  title VARCHAR(255) not null,
  content text not null,
  id_category int not null,
  id_user int not null,
  image VARCHAR(255) null,
  slug VARCHAR(255) not null UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_category) REFERENCES categories(id),
  FOREIGN KEY (id_user) REFERENCES users(id)
);

insert into users (username, password, name) values
('admin', '$2a$12$IArpob1OXmAcaPTuIlkpauluV005F1gevAYc2GSyBiDwHO6YQxBh2', 'Administrator');