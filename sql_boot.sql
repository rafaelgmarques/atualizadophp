use atualizadophp;

create table boot (
	 idUpdate bigint primary key not null #update_id
	,idChat bigint not null #chat_id
    ,resposta varchar(500) not null #resposta enviada
    ,idComando int not null #referencia ao comando
    ,foreign key (idComando) references comando(idComando));
    
create table comando (
	 idComando int not null primary key AUTO_INCREMENT
    ,comando varchar(45) not null);
    
select * from boot;
select * from comando;

SELECT idUpdate,idChat,resposta,comando FROM boot b INNER JOIN comando c ON b.idComando=c.idComando;