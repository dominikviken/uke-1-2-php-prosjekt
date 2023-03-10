drop database if exists excuses;

create database excuses;
use excuses;

create table occasions (
id int primary key auto_increment,
occasion varchar(255)
);

create table excuses (
id int primary key auto_increment,
parent_id int,
excuse varchar(255),
date varchar(30),
timesUsed int default 0,
foreign key (parent_id) references occasions(id)
);

insert into occasions (occasion)
values ("Kom sent til skolen?"), ("Skulket du skole?"), ("Hvorfor tapte du i spill?"), ("Hvorfor brukte du lang tid på do?"), ("Glemte du noe hjemme?");

insert into excuses (parent_id, excuse)
values (1, "Jeg falt i kloakken."), (1, "Bussen var sen."), (1, "Jeg måtte gå tur med hunden min."), 
(2, "Jeg måtte på en begravelse."), (2, "Kneet mitt gikk ut av ledd, og jeg måtte til sykehuset."),
(3, "Henda mine var kalde."), (3, "Sola blenda meg."), (3, "Kontrolleren min ble koblet fra"),
(4, "Jeg måtte vente på at noen skulle gå ut.");
