DELIMITER //
drop table if exists phone cascade;
drop table if exists user cascade;


/*Creacion de tablas*/

create table user(
                     useruuid VARCHAR(36),
                     usernick VARCHAR(100) NOT NULL,
                     userpass VARCHAR(255) NOT NULL,
                     userdni VARCHAR(9) NOT NULL,
                     useremail VARCHAR(255) NOT NULL,
                     userbirthdate DATE,
                     username VARCHAR(100) NOT NULL,
                     usersurname VARCHAR(255) NOT NULL,
                     useradress VARCHAR(255),
                     usermark DECIMAL(5,2),
                     usercard VARCHAR(16),
                     userdata JSON,
                     usertype ENUM('admin','user','superuser','god','guest') NOT NULL
);
//

create table phone(
                         phoneid BIGINT AUTO_INCREMENT PRIMARY KEY,
                         phoneprefix VARCHAR(5),
                         phonenumber VARCHAR(9),
                         useruuid VARCHAR(36)
);
//
/*Creación de claves primarias*/
alter table user add constraint pk_user primary key (useruuid);
alter table user add constraint uk_user_dni unique (userdni);
alter table user add constraint uk_user_email unique (useremail);
//
/*alter table telefono add constraint pk_telefono primary key (id);*/

/*Creación de claves ajenas*/

alter table phone add constraint fk_phone_user
    foreign key (useruuid) references user(useruuid) on delete cascade;
//