drop database if exists `auth`;
create database `auth`;
use `auth`;

create table `users` (
    `id`              	integer not null primary key auto_increment,
    `register`        	timestamp not null default current_timestamp, 
    `name`            	varchar(150) not null,
	`user`			    varchar(50) not null,
    `email`           	varchar(200) not null,
    `pass`           	varchar(255) not null,
    `active`           	tinyint not null default 1    
)engine=MyISAM;
insert into `users` (`name`, `user`, `email`, `pass`) values 
('ADMINISTRATOR', 'ADMIN', 'admim@email.com', '$2y$10$UWRbumrwew6DA/.YAAbHPed6cD.QgF/xfnOWdYRk3Et/jpJlPWB2a'); -- PASS 123456


create table `auth` (
	`id`              	integer not null primary key auto_increment,
    `register`        	timestamp not null default current_timestamp, 
	`id_user`   		integer not null references `usuarios`(`id`) on delete restrict,
	`token`				varchar(100) not null,
	`validate`			integer not null default 0,
	`ip`				varchar(20),
	`date_auth`			timestamp not null default current_timestamp				
)engine=MyISAM;

