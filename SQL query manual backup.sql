CREATE DATABASE projectmanagementapp

CREATE TABLE projectmanagementapp.PROJECT ( 
    ProjectID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    ProjectName varchar(20), 
    ProjectLeaderID int(6) NOT NULL, 
    FlagStatus varchar(1),
    Revenue double, 
    NetGainOrLoss double, 
    Start_Date date, 
    End_Date date
);

CREATE TABLE projectmanagementapp.CLIENT (
	ClientID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ProjectID int(6),
    ClientName varchar(20),
    Email varchar(50),
    Phone1 bigint(10),
    Phone2 bigint(10),
    FOREIGN KEY (ProjectID) REFERENCES project(ProjectID)
);

CREATE TABLE projectmanagementapp.EMPLOYEE (
	EmployeeID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    EmployeeName varchar(30),
    Phone1 bigint(10),
    Phone2 bigint(10),
    Email varchar(50),
    HourlyRate double
);

ALTER TABLE `project` CHANGE `ProjectLeaderID` `ProjectLeaderID` INT(6) NOT NULL, 
add FOREIGN KEY (`ProjectLeaderID`) REFERENCES employee(EmployeeID);

CREATE TABLE projectmanagementapp.TASK(
	TaskID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    Description varchar(255),
    StartDate date,
    DueDate date,
    FinishDate date,
    FlagStatus varchar(1),
    FlagActive varchar(1)
);

CREATE TABLE projectmanagementapp.BUDGET(
	BudgetID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ProjectID int(6) NOT NULL,
    ItemName varchar(25),
    AllocationCost double,
    EmpID int(6) NULL,
    WorksID int(6) NULL,
    FOREIGN KEY (ProjectID) REFERENCES project(ProjectID)
);

CREATE TABLE projectmanagementapp.WORKS_ON(
	WorksID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ProjectID int(6) NOT NULL,
    EmployeeID int(6) NOT NULL,
    TaskID int(6) NOT NULL,
    WorkingHours double,
    FOREIGN KEY (ProjectID) REFERENCES project(ProjectID),
    FOREIGN KEY (EmployeeID) REFERENCES employee(EmployeeID),
    FOREIGN KEY (TaskID) REFERENCES task(TaskID)
);

CREATE TABLE projectmanagementapp.USER_LOGIN(
	Username varchar(15) PRIMARY KEY NOT NULL,
    ClientID int(6),
    EmployeeID int(6),
    PasswordHash BINARY(20) NOT NULL,
    Salt BINARY(20) NOT NULL,
    FOREIGN KEY (ClientID) REFERENCES client(ClientID),
    FOREIGN KEY (EmployeeID) REFERENCES employee(EmployeeID)
);

CREATE TABLE projectmanagementapp.MENU(
	MenuID int(6) PRIMARY KEY AUTO_INCREMENT,
    MenuName varchar(30) NOT NULL,
    url varchar(50)
);

CREATE TABLE projectmanagementapp.ASSIGNED_MENU(
	AssignedID int(6) PRIMARY KEY AUTO_INCREMENT,
    MenuID int(6) NOT NULL,
    Username varchar(15),
    FOREIGN KEY (MenuID) REFERENCES MENU(MenuID),
    FOREIGN KEY (Username) REFERENCES USER_LOGIN(Username)
);

INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Manage Projects','index1.php');
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Manage Employees','employees.php');
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Manage Clients','client.php');
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Task Progress Report','clientReporting.php');
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Budget Report', 'BudgetReport.php');
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ("Manage Employees' Tasks", "task.php");
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Manage Budget', 'budget.php');
INSERT INTO `MENU`(`MenuName`, `url`) VALUES ('Update Works On', 'works_on_update.php');

INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (1, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (2, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (3, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (1, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (2, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (3, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (1, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (2, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (3, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (1, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (2, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (3, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (1, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (2, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (3, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (4, 'jsmith');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (5, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (5, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (5, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (5, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (5, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (6, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (6, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (6, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (6, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (6, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (7, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (7, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (7, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (7, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (7, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'jlimano');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'junren');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'dbotello');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'violeta');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'yaseen');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'jdoe');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES (8, 'jdoe2');
INSERT INTO `ASSIGNED_MENU`(`MenuID`, `Username`) VALUES ('4','dsmith');

INSERT INTO EMPLOYEE(EmployeeName, Phone1, Phone2, Email,  HourlyRate) VALUES ('Daniel Botello', '7135971511', '2816206780', 'danielbotello2000@yahoo.com', '15');
INSERT INTO EMPLOYEE(EmployeeName, Phone1, Phone2, Email, HourlyRate) values('Johannes Limano','3465589090','','johannes.dominic@gmail.com','15');
INSERT INTO EMPLOYEE(EmployeeName, Phone1, Phone2, Email,  HourlyRate) VALUES ('Violeta', '1234567891', '', 'violeta@gmail.com', '15');
INSERT INTO EMPLOYEE(EmployeeName, Phone1, Phone2, Email,  HourlyRate) VALUES ('Junren', '4561236897', '', 'junren@gmail.com', '15');
INSERT INTO EMPLOYEE(EmployeeName, Phone1, Phone2, Email,  HourlyRate) VALUES ('Yaseen', '3641237452', '', 'yaseen@gmail.com', '15');

DELIMITER $$
CREATE PROCEDURE user_auth(IN user_name CHAR(15), IN pass VARCHAR(20))
BEGIN
	SELECT USER_LOGIN.Username, USER_LOGIN.salt INTO @id, @salt FROM USER_LOGIN WHERE USER_LOGIN.username = user_name;
	IF (SELECT COUNT(USER_LOGIN.Username) FROM USER_LOGIN WHERE USER_LOGIN.Username = user_name AND USER_LOGIN.PasswordHash = UNHEX(SHA1(CONCAT(HEX(@salt), pass)))) != 1 THEN
		SET @message_text = 'Login incorrect';
		SELECT @message_text as response;
	ELSE
		SELECT @id AS username;
	END IF;
END$$

DELIMITER $$
CREATE PROCEDURE user_create(IN user_name varchar(15), IN pass varchar(20))
BEGIN
	IF (SELECT COUNT(USER_LOGIN.Username) FROM USER_LOGIN WHERE USER_LOGIN.Username = user_name) > 0 THEN
		SET @message_text = CONCAT('Username \'', user_name, '\' already exists');
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
	ELSE
		SET @salt = UNHEX(SHA1(CONCAT(RAND(), RAND(), RAND())));
		INSERT INTO USER_LOGIN(Username, ClientID, EmployeeID, PasswordHash, Salt)
        VALUES (user_name, NULL, NULL, UNHEX(SHA1(CONCAT(HEX(@salt), pass))), @salt);
	END IF;
END$$

/*delimiter, create procedure and grant user on procedure were sourced from: https://gist.github.com/doobry/1106727*/

/*employee*/
CALL user_create('jlimano', SHA1('password'));
CALL user_create('dbotello', SHA1('password'));
CALL user_create('violeta', SHA1('password'));
CALL user_create('yaseen', SHA1('password'));
CALL user_create('junren', SHA1('password'));
/*client*/
CALL user_create('jsmith', SHA1('password'));
CALL user_create('aflores', SHA1('password'));
CALL user_create('bfloyd', SHA1('password'));

CALL user_create('jdoe', SHA1('passphrase123')); /*employee*/
CALL user_create('jdoe2', SHA1('passphrase123')); /*employee*/
CALL user_create('dsmith', SHA1('passphrase123')); /*client*/

CALL user_auth('jlimano',SHA1('password'));
CALL user_auth('dbotello',SHA1('password'));
CALL user_auth('violeta',SHA1('password'));

/*FlagStatus A:Active or Ongoing Project, I:Inactive or Upcoming Project, C:Completed Project*/
INSERT INTO `PROJECT`(`ProjectName`, `ProjectLeaderID`, `FlagStatus`, `Revenue`, `Start_Date`, `End_Date`) VALUES ('XYZ Car Rental', 4, 'A','32000','2020-03-21','2020-07-21');
INSERT INTO `PROJECT`(`ProjectName`, `ProjectLeaderID`, `FlagStatus`, `Revenue`, `Start_Date`, `End_Date`) VALUES ('Z Mobile E-Payments', 6, 'I','50000','2020-05-15','2020-09-15');
INSERT INTO `PROJECT`(`ProjectName`, `ProjectLeaderID`, `FlagStatus`, `Revenue`, `Start_Date`, `End_Date`) VALUES ('Vienna Wine Store', 7, 'I','45000','2020-07-08','2020-11-12');

INSERT INTO `CLIENT`(`ProjectID`, `ClientName`, `Email`, `Phone1`, `Phone2`) VALUES (1,'John Smith','johnsmith@xyz.net','5698751289','6485693321');
INSERT INTO `CLIENT`(`ProjectID`, `ClientName`, `Email`, `Phone1`, `Phone2`) VALUES (2,'Anna Flores','annaflores@zpayments.biz','4895632212','');
INSERT INTO `CLIENT`(`ProjectID`, `ClientName`, `Email`, `Phone1`, `Phone2`) VALUES (3,'Brianna Floyd','bfloyd@viennawine.com','3658975562','');

/*FlagStatus C:Completed in time or before due, L: completed after due or late, O:ongoing, U:upcoming*/
/*FlagActive A:data still present, D: data is "deleted"*/
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Setting up the repository','2020-03-21','2020-03-21','2020-03-21','C','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Client meeting for  gathering requirements','2020-03-23','2020-03-23','2020-03-23','C','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Database Design','2020-03-23','2020-03-26','2020-03-26','C','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Database Insertions','2020-03-26','2020-03-30','2020-03-31','L','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Data Request from Client','2020-03-26','2020-03-30','2020-03-31','L','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end from Adobe Xd','2020-03-31','2020-04-07','2020-04-07','C','D');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end design','2020-03-31','2020-04-07','2020-04-07','O','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FinishDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client for prototype','2020-04-08','2020-04-08',NULL,'U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end code','2020-04-08','2020-04-17','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Connecting between front-end and back-end','2020-04-17','2020-04-28','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client for finished prototype','2020-04-29','2020-04-29','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Bug fixing and polishing','2020-04-29','2020-05-06','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Deployement to Server','2020-05-06','2020-05-15','U','A');

/*task id 1-13 are for 1st project*/

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','1','1');

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','2','3');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','2','3');

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','3','24');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','3','24');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','3','24');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','3','24');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','3','24');

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','4','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','4','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','4','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','4','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','4','30');

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','5','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','5','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','5','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','5','30');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','5','30');

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','7','48');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','7','48');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','7','48');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','7','48');
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','7','48');

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','8',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','8',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','9',61);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','9',61);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','9',61);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','9',61);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','9',61);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','10',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','10',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','10',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','10',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','10',64);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','11',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','11',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','12',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','12',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','12',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','12',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','12',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','4','13',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','5','13',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','6','13',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','7','13',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('1','8','13',64);

INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Repository setup','2020-05-15','2020-05-15','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client to gather requirements','2020-05-15','2020-05-15','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Tools and libraries research for android and iOS app development','2020-05-18','2020-06-01','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Database design','2020-06-02','2020-06-09','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Database insertions','2020-06-10','2020-06-17','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Data request from client and API access request','2020-06-10','2020-06-17','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end design','2020-06-17','2020-06-24','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client for prototype','2020-06-25','2020-06-25','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end code','2020-06-25','2020-07-09','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Back-end code','2020-06-25','2020-07-09','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Connecting front-end with back-end','2020-07-10','2020-07-21','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client for finished prototype','2020-07-22','2020-07-22','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Bug-fixing and polishing','2020-07-22','2020-08-05','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Deployment','2020-08-06','2020-08-20','U','A');

/*TASK id 14-27 are for 2nd project*/

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','14',1);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','15',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','15',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','16',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','16',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','16',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','16',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','16',88);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','17',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','17',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','17',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','17',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','17',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','18',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','18',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','18',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','19',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','19',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','20',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','20',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','20',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','20',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','20',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','21',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','21',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','22',72);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','22',69);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','23',69);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','23',72);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','23',72);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','24',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','24',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','24',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','24',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','24',64);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','25',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','25',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','26',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','26',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','26',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','26',85);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','26',85);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','4','27',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','5','27',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','6','27',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','7','27',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('2','8','27',88);

INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Repository setup','2020-07-08','2020-07-08','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client to gather requirements','2020-07-08','2020-07-08','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Tools and libraries research for android and iOS app development','2020-07-09','2020-07-22','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Database design','2020-07-23','2020-07-30','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Database insertions','2020-07-31','2020-08-11','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Data request from client and API access request','2020-07-31','2020-08-11','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end design','2020-08-12','2020-08-19','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client for prototype','2020-08-20','2020-08-20','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Front-end code','2020-08-20','2020-09-03','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Back-end code','2020-08-20','2020-09-03','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Connecting front-end with back-end','2020-09-04','2020-09-11','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Meeting with client for finished prototype','2020-09-14','2020-09-14','U','A');

INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Bug-fixing and polishing','2020-09-15','2020-09-29','U','A');
INSERT INTO `TASK`(`Description`, `StartDate`, `DueDate`, `FlagStatus`, `FlagActive`) VALUES ('Deployment','2020-09-30','2020-10-14','U','A');

/*TASK id 28-41 are for 3rd project*/

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','28',1);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','29',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','29',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','30',80);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','30',80);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','30',80);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','30',80);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','30',80);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','31',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','31',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','31',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','31',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','31',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','32',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','32',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','32',64);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','33',64);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','33',64);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','34',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','34',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','34',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','34',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','34',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','35',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','35',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','36',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','36',85);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','37',85);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','37',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','37',88);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','38',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','38',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','38',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','38',48);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','38',48);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','39',3);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','39',3);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','40',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','40',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','40',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','40',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','40',88);

INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','4','41',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','5','41',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','6','41',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','7','41',88);
INSERT INTO `WORKS_ON`(`ProjectID`, `EmployeeID`, `TaskID`, `WorkingHours`) VALUES ('3','8','41',88);

/*This is used to insert BUDGET breakdown data into BUDGET table for employees' salary. Also this can be used as a possible database trigger.*/
INSERT INTO `BUDGET`(`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('1','Salary EmployeeID 5',
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 1 AND WORKS_ON.EmployeeID = 5)
);
INSERT INTO `BUDGET`(`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('1','Salary EmployeeID 4',
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 1 AND WORKS_ON.EmployeeID = 4)
);
INSERT INTO `BUDGET`(`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('1','Salary EmployeeID 6',
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 1 AND WORKS_ON.EmployeeID = 6)
);
INSERT INTO `BUDGET`(`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('1','Salary EmployeeID 7',
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 1 AND WORKS_ON.EmployeeID = 7)
);
INSERT INTO `BUDGET`(`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('1','Salary EmployeeID 8',
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 1 AND WORKS_ON.EmployeeID = 8)
);
/*BUDGET for Project 2*/
INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('2', 'Salary EMPLOYEE ID 4', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 2 AND WORKS_ON.EmployeeID = 4));

 INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('2', 'Salary EMPLOYEE ID 5', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 2 AND WORKS_ON.EmployeeID = 5));

 INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('2', 'Salary EMPLOYEE ID 6', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 2 AND WORKS_ON.EmployeeID = 6));

INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('2', 'Salary EMPLOYEE ID 7', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 2 AND WORKS_ON.EmployeeID = 7));

INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('2', 'Salary EMPLOYEE ID 8', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 2 AND WORKS_ON.EmployeeID = 8));
/*Project 3*/
INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('3', 'Salary EMPLOYEE ID 4', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 3 AND WORKS_ON.EmployeeID = 4));

INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('3', 'Salary EMPLOYEE ID 5', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 3 AND WORKS_ON.EmployeeID = 5));

INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('3', 'Salary EMPLOYEE ID 6', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 3 AND WORKS_ON.EmployeeID = 6));

INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('3', 'Salary EMPLOYEE ID 7', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 3 AND WORKS_ON.EmployeeID = 7));

INSERT INTO `BUDGET` (`ProjectID`, `ItemName`, `AllocationCost`) VALUES ('3', 'Salary EMPLOYEE ID 8', 
    (SELECT SUM(WorkingHours*HourlyRate) AS PaymentSum
    FROM `WORKS_ON`, `EMPLOYEE`
    WHERE WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID AND WORKS_ON.ProjectID = 3 AND WORKS_ON.EmployeeID = 8));


/*This is to update net gain or loss of each PROJECT that already has BUDGET breakdowns in BUDGET table. Also, a possible database trigger.*/
UPDATE `PROJECT` SET `NetGainOrLoss` = 
    (SELECT Revenue -     
        (SELECT SUM(AllocationCost) AS TotalExpenditures
        FROM `BUDGET`,`PROJECT` 
        WHERE BUDGET.ProjectID = PROJECT.ProjectID AND BUDGET.ProjectID = 1)
    AS Net
    FROM PROJECT
    WHERE PROJECT.ProjectID = 1)
WHERE `PROJECT`.`ProjectID` = 1;

UPDATE `PROJECT` SET `NetGainOrLoss` = 
    (SELECT Revenue -     
        (SELECT SUM(AllocationCost) AS TotalExpenditures
        FROM `BUDGET`,`PROJECT` 
        WHERE BUDGET.ProjectID = PROJECT.ProjectID AND BUDGET.ProjectID = 2)
    AS Net
    FROM PROJECT
    WHERE PROJECT.ProjectID = 2)
WHERE `PROJECT`.`ProjectID` = 2;

UPDATE `PROJECT` SET `NetGainOrLoss` = 
    (SELECT Revenue -     
        (SELECT SUM(AllocationCost) AS TotalExpenditures
        FROM `BUDGET`,`PROJECT` 
        WHERE BUDGET.ProjectID = PROJECT.ProjectID AND BUDGET.ProjectID = 3)
    AS Net
    FROM PROJECT
    WHERE PROJECT.ProjectID = 3)
WHERE `PROJECT`.`ProjectID` = 3;

/*OLD SALARY_UPDATE_INFORM*/
IF NEW.HourlyRate <= (SELECT HourlyRate
    FROM `PROJECT`, `EMPLOYEE` WHERE PROJECT.ProjectLeaderID = NEW.EmployeeID  AND NEW.HourlyRate > OLD.HourlyRate) THEN
        INSERT INTO SALARY_REQUEST(`EmployeeID`,`ProjectID`,`NewSalary`,`RequestDate`,`FlagStatus`) 
        VALUES(NEW.EmployeeID, 
              (SELECT ProjectID FROM `WORKS_ON` WHERE EmployeeID = NEW.EmployeeID LIMIT 1), NEW.HourlyRate, CURRENT_DATE, 'W');

ELSEIF NEW.HourlyRate <= HourlyRate THEN
        SET @message_text = CONCAT('new salary must be greater than current salary');
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;

ELSEIF NEW.HourlyRate > (SELECT EMPLOYEE.HourlyRate
    FROM `PROJECT`, `EMPLOYEE` WHERE PROJECT.ProjectLeaderID = EMPLOYEE.EmployeeID) THEN
        SET @message_text = CONCAT('new salary must be less or equal to project leader salary');
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
    END IF

/*NEW SALARY_UPDATE_INFORM Trigger*/
IF NEW.HourlyRate <= (SELECT DISTINCT b.ProjectID, b.ProjectLeaderID, c.HourlyRate FROM `WORKS_ON` AS a, `PROJECT` AS b, `EMPLOYEE` AS c WHERE b.ProjectID = a.ProjectID AND c.EmployeeID = a.EmployeeID AND c.EmployeeID = NEW.EmployeeID LIMIT 1) AND (NEW.HourlyRate > OLD.HourlyRate) THEN
        INSERT INTO SALARY_REQUEST(`EmployeeID`,`ProjectID`,`NewSalary`,`RequestDate`,`FlagStatus`) 
        VALUES(NEW.EmployeeID, 
              (SELECT ProjectID FROM `WORKS_ON` WHERE EmployeeID = NEW.EmployeeID LIMIT 1), NEW.HourlyRate, CURRENT_DATE, 'W');

ELSEIF NEW.HourlyRate <= HourlyRate THEN
        SET @message_text = CONCAT('new salary must be greater than current salary');
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;

ELSEIF NEW.HourlyRate > (SELECT EMPLOYEE.HourlyRate
    FROM `PROJECT`, `EMPLOYEE` WHERE PROJECT.ProjectLeaderID = EMPLOYEE.EmployeeID) THEN
        SET @message_text = CONCAT('new salary must be less or equal to project leader salary');
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @message_text;
    END IF

/*Trigger Insert_WO_Trigger*/
INSERT INTO BUDGET (`ProjectID`, `ItemName`, `AllocationCost`, `EmpID`, `WorksID`)
VALUES (NEW.ProjectID, 'SALARY INFO',
        NEW.WorkingHours * (SELECT `HourlyRate`
                        FROM `EMPLOYEE`
                        WHERE EMPLOYEE.EmployeeID = NEW.EmployeeID),
        NEW.EmployeeID, (SELECT AUTO_INCREMENT 
                         FROM information_schema.TABLES 
                         WHERE TABLE_SCHEMA = "projectmanagementapp" 
                         AND TABLE_NAME = "WORKS_ON")
       )

/*Trigger Update_WO_Trigger*/
UPDATE BUDGET
SET BUDGET.AllocationCost = (
    SELECT NEW.WorkingHours * EMPLOYEE.HourlyRate
    FROM EMPLOYEE
    WHERE EMPLOYEE.EmployeeID = NEW.EmployeeID 
)
WHERE BUDGET.WorksID = NEW.WorksID
/*---------------------------------------------------------------------------*/
/*WORKS_ON UPDATE*/
/*need to have 3 dropdown select box.*/
/*1st select box performs list every project*/
SELECT ProjectID, ProjectName FROM PROJECT
/*then capture the selected ProjectID value (selected_project_id)*/

/*2nd select box performs list every employee working in that project above*/
SELECT DISTINCT EMPLOYEE.EmployeeID, EMPLOYEE.EmployeeName FROM EMPLOYEE
INNER JOIN WORKS_ON
ON WORKS_ON.EmployeeID = EMPLOYEE.EmployeeID
WHERE WORKS_ON.ProjectID = selected_project_id
/*then capture the selected EmployeeID value (selected_employee_id)*/

/*3rd select box performs list every row of WORKS_ON that has selected_project_id and selected_employee_id*/
SELECT WORKS_ON.WorksID, TASK.Description, TASK.StartDate, TASK.DueDate, WORKS_ON.WorkingHours FROM WORKS_ON, TASK
WHERE TASK.TaskID = WORKS_ON.TaskID 
AND WORKS_ON.EmployeeID = selected_employee_id 
AND WORKS_ON.ProjectID = selected_project_id
/*then capture the WorksID (selected_works_id)*/

UPDATE WORKS_ON
SET WorkingHours = value_from_input
WHERE WorksID = selected_works_id
/*---------------------------------------------------------------------------*/
/*Reporting for Client*/
SELECT DISTINCT TASK.Description AS 'Task', TASK.StartDate AS 'Start', TASK.DueDate AS 'Due', IF(
    TASK.FlagStatus='C','Completed', IF(
        TASK.FlagStatus='L','Late',IF(
            TASK.FlagStatus='O','Ongoing', IF(
                TASK.FlagStatus='U','Upcoming','N/A')))) 
    AS 'Task Status', IF(
        TASK.FinishDate IS NULL,'N/A',TASK.FinishDate) 
    AS 'Finished on'
FROM TASK, WORKS_ON
WHERE TASK.TaskID = WORKS_ON.TaskID
AND WORKS_ON.ProjectID = 1;

/*Budget Breakdown Report*/
SELECT "Employee Salary" AS Description, SUM(AllocationCost) AS "Expense Amount"
FROM BUDGET
WHERE ProjectID = 1
AND ItemName LIKE '%salary%'

UNION

SELECT BUDGET.ItemName AS Description, BUDGET.AllocationCost AS "Expense Amount"
FROM BUDGET
WHERE ProjectID = 1
AND ItemName NOT LIKE '%salary%';