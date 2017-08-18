<?php
require_once "libs/conn.php";
if (!$conn->query("DROP TABLE IF EXISTS slc_utenti"))
{
    die($conn->error);
}
if (!$conn->query("create table slc_utenti
(
	ID int(10) unsigned auto_increment
		primary key,
	Nome varchar(255) null,
	Cognome varchar(255) null,
	NomeUtente varchar(16) not null,
	Password varchar(255) not null,
	TarantelleSubite mediumblob null comment 'Massimo 524288 Tarantelle',
	TarantelleSchiate mediumblob null comment 'Massimo 524288 Tarantelle',
	constraint slc_utenti_NomeUtente_uindex
		unique (NomeUtente)
);"))
{
    die($conn->error);
}