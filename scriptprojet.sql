#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Agency
#------------------------------------------------------------

CREATE TABLE Agency(
        id             Int  Auto_increment  NOT NULL ,
        name           Varchar (6) NOT NULL ,
        address        Varchar (255) NOT NULL ,
        is_main_agency Bool NOT NULL
	,CONSTRAINT Agency_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Agent
#------------------------------------------------------------

CREATE TABLE Agent(
        id        Int  Auto_increment  NOT NULL ,
        email     Varchar (255) NOT NULL ,
        name      Varchar (255) NOT NULL ,
        id_Agency Int NOT NULL
	,CONSTRAINT Agent_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Type
#------------------------------------------------------------

CREATE TABLE Type(
        id   Int  Auto_increment  NOT NULL ,
        name Varchar (255) NOT NULL
	,CONSTRAINT Type_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Outbuilding
#------------------------------------------------------------

CREATE TABLE Outbuilding(
        id   Int  Auto_increment  NOT NULL ,
        name Varchar (255) NOT NULL
	,CONSTRAINT Outbuilding_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Possession 
#------------------------------------------------------------

CREATE TABLE Possession(
        id                Int  Auto_increment  NOT NULL ,
        surface           Int NOT NULL ,
        RoomNumber        Int NOT NULL ,
        FloorNumber       Int NOT NULL ,
        localisation      Varchar (255) NOT NULL ,
        description       Varchar (255) NOT NULL ,
        prix_minimum      Float NOT NULL ,
        prix_maximum      Float NOT NULL ,
        selling_price     Float NOT NULL ,
        agency_costs_sell Int NOT NULL ,
        agency_costs_buy  Int NOT NULL ,
        id_Client         Int NOT NULL ,
        id_Type           Int NOT NULL
	,CONSTRAINT Possession_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Client
#------------------------------------------------------------

CREATE TABLE Client(
        id        Int  Auto_increment  NOT NULL ,
        email     Varchar (255) NOT NULL ,
        password  Varchar (255) NOT NULL ,
        firstname Varchar (255) NOT NULL ,
        lastname  Varchar (255) NOT NULL ,
        address   Varchar (255) NOT NULL ,
        phone     Varchar (255) NOT NULL ,
        type      Varchar (50) NOT NULL ,
        id_Client Int ,
        id_Agency Int NOT NULL ,
        id_Agent  Int NOT NULL
	,CONSTRAINT Client_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Proposition
#------------------------------------------------------------

CREATE TABLE Proposition(
        id        Int NOT NULL ,
        id_Client Int NOT NULL ,
        Prix      Int NOT NULL ,
        Date      Date NOT NULL
	,CONSTRAINT Proposition_PK PRIMARY KEY (id,id_Client)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ownOutbuilding
#------------------------------------------------------------

CREATE TABLE ownOutbuilding(
        id             Int NOT NULL ,
        id_Possession  Int NOT NULL ,
        Surface        Int NOT NULL ,
        description    Varchar (255) NOT NULL
	,CONSTRAINT ownOutbuilding_PK PRIMARY KEY (id,id_Possession)
)ENGINE=InnoDB;




ALTER TABLE Agent
	ADD CONSTRAINT Agent_Agency0_FK
	FOREIGN KEY (id_Agency)
	REFERENCES Agency(id);

ALTER TABLE Possession
	ADD CONSTRAINT Possession_Client0_FK
	FOREIGN KEY (id_Client)
	REFERENCES Client(id);

ALTER TABLE Possession
	ADD CONSTRAINT Possession_Type1_FK
	FOREIGN KEY (id_Type)
	REFERENCES Type(id);

ALTER TABLE Client
	ADD CONSTRAINT Client_Client0_FK
	FOREIGN KEY (id_Client)
	REFERENCES Client(id);

ALTER TABLE Client
	ADD CONSTRAINT Client_Agency1_FK
	FOREIGN KEY (id_Agency)
	REFERENCES Agency(id);

ALTER TABLE Client
	ADD CONSTRAINT Client_Agent2_FK
	FOREIGN KEY (id_Agent)
	REFERENCES Agent(id);

ALTER TABLE Proposition
	ADD CONSTRAINT Proposition_Possession0_FK
	FOREIGN KEY (id)
	REFERENCES Possession(id);

ALTER TABLE Proposition
	ADD CONSTRAINT Proposition_Client1_FK
	FOREIGN KEY (id_Client)
	REFERENCES Client(id);

ALTER TABLE ownOutbuilding
	ADD CONSTRAINT ownOutbuilding_Outbuilding0_FK
	FOREIGN KEY (id)
	REFERENCES Outbuilding(id);

ALTER TABLE ownOutbuilding
	ADD CONSTRAINT ownOutbuilding_Possession1_FK
	FOREIGN KEY (id_Possession)
	REFERENCES Possession(id);
