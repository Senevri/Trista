 create table pages (id int, name varchar(255), template varchar(255), primary key (id));
 create table contents (id int, page int, name varchar(255), data text, language char(2) default "fi", primary key (id), foreign key (page) references pages(id));