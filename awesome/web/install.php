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
	UniqID varchar(13) not null,
	Nome varchar(255) null,
	Cognome varchar(255) null,
	NomeUtente varchar(16) not null,
	Password varchar(255) not null,
	UltimaSchiata timestamp default CURRENT_TIMESTAMP not null,
	constraint slc_utenti_UniqID_uindex
		unique (UniqID),
	constraint slc_utenti_NomeUtente_uindex
		unique (NomeUtente)
);"))
{
    die($conn->error);
}

if (!$conn->query("DROP TABLE IF EXISTS slc_tarantelle"))
{
    die($conn->error);
}

if (!$conn->query("create table slc_tarantelle
(
	ID int(10) unsigned auto_increment
		primary key,
	Destinatario int(10) unsigned not null,
	Mittente int(10) unsigned not null,
	Corpo varchar(500) not null,
	Anonimo bit default b'1' not null,
	Risposta varchar(500) null,
	DataCreazione timestamp default CURRENT_TIMESTAMP not null
);"))
{
    die($conn->error);
}