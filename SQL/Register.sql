USE sacra_mento;

CREATE TABLE sacra_Register (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Reg_No TEXT,
    First_Name TEXT DEFAULT NULL,
    Last_Name TEXT DEFAULT NULL,
    Email TEXT DEFAULT NULL,
    Phone_Number TEXT DEFAULT NULL,
    Entry_Fees TEXT DEFAULT NULL,
    Willingness TEXT DEFAULT NULL,
    Number_Guests TEXT DEFAULT NULL,
    Adults TEXT DEFAULT NULL,
    Kids TEXT DEFAULT NULL,
    Babes TEXT DEFAULT NULL,
    Event TEXT DEFAULT NULL,
    Team_Name TEXT DEFAULT NULL,
    Eventname TEXT DEFAULT NULL,
    Poster_Type TEXT DEFAULT NULL,
    Team_Members_Count TEXT DEFAULT NULL,
    Disclaimer_Acceptance TEXT DEFAULT NULL,
    created_date TIMESTAMP DEFAULT NOW(),
    updated_date TIMESTAMP DEFAULT NOW() ON UPDATE NOW()
);