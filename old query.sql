CREATE TABLE projectmanagementapp.PROJECT ( 
    ProjectID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    ProjectName varchar(20), 
    ProjectLeaderID int(6) NOT NULL, 
    FlagStatus varchar(1), 
    NetGainOrLoss int(10), 
    Start_Date date, 
    End_Date date 
);

CREATE TABLE projectmanagementapp.CLIENT (
	ClientID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ProjectID int(6) NOT NULL,
    ClientName varchar(20),
    Email varchar(20),
    Phone1 int(10),
    Phone2 int(10),
    FOREIGN KEY (ProjectID) REFERENCES project(ProjectID)
);

CREATE TABLE projectmanagementapp.EMPLOYEE (
	EmployeeID int(6) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    EmployeeName varchar(30),
    Phone1 int(10),
    Phone2 int(10),
    Email varchar(20),
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
    TotalHours double,
    FlagActive varchar(1)
);