CREATE DATABASE meanbymin;

USE meanbymin;

CREATE TABLE min_member(
	min_idx bigint auto_increment primary key,
    min_userid varchar(20) unique not null,
    min_userpw varchar(20) not null,
    min_name varchar(20) not null,
    min_biryy varchar(4) not null,
    min_birmm varchar(2) not null,
    min_birdd varchar(2) not null,
    min_ssn1 varchar(6) not null,
    min_ssn2 varchar(7) not null,
    min_gender enum('남자', '여자', '선택안함') not null,
    min_email varchar(50),
    min_hp varchar(13) not null,
    min_zipcode varchar(5) not null,
    min_address1 varchar(50),
	min_address2 varchar(50),
    min_address3 varchar(50),
    min_regdate datetime default now()
);

SELECT min_idx, min_userid, min_userpw, min_name, min_biryy, min_birmm, min_birdd, min_ssn1, min_ssn2, min_gender, min_email, min_hp, min_zipcode, min_address1, min_address2, min_address3, min_regdate FROM min_member;

INSERT INTO min_member (min_userid, min_userpw, min_name, min_biryy, min_birmm, min_birdd, min_ssn1, min_ssn2, min_gender, min_email, min_hp, min_zipcode, min_address1, min_address2, min_address3) VALUES ('admin', '1234', '관리자', '1992', '08', '10', '920810', '1824111', '남자',  'meanbymin@meanbymin.com', '010-0000-0000', '12345', '서울', '광진구', '자양동');