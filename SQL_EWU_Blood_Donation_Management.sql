CREATE TABLE designation (
    des_id INT AUTO_INCREMENT PRIMARY KEY,
    des_name VARCHAR(20) UNIQUE NOT NULL
)ENGINE=InnoDB;

CREATE TABLE Role (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(20) UNIQUE NOT NULL
)ENGINE=InnoDB;



CREATE TABLE Blood_Group (
    blood_group_id INT AUTO_INCREMENT PRIMARY KEY,
    blood_group VARCHAR(5) UNIQUE
);


CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    des_id INT NOT NULL,        -- student / faculty / staff
	role_id INT NOT NULL, -- admin/ organizer/ staff
    blood_group_id INT,
    dob DATE,
    gender VARCHAR(10),
	FOREIGN KEY (blood_group_id) REFERENCES Blood_Group(blood_group_id),
	FOREIGN KEY (des_id) REFERENCES designation(des_id),
	FOREIGN KEY (role_id) REFERENCES Role(role_id)
	
) ENGINE=InnoDB;

CREATE TABLE Event (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    organizer_id INT NOT NULL,
    event_name VARCHAR(100),
    event_date DATE,
    location VARCHAR(100),
    description TEXT,

    FOREIGN KEY (organizer_id) REFERENCES Users(user_id)
) ENGINE=InnoDB;


CREATE TABLE Eligibility (
    eligibility_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    last_donation_date DATE,
    next_eligible_date DATE,
    health_status VARCHAR(50),
    weight DECIMAL(5,2),
    hemoglobin_level DECIMAL(5,2),
    eligibility_flag VARCHAR(20),   -- eligible / not eligible
    notes TEXT,
    event_id INT,

    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (event_id) REFERENCES Event(event_id)
) ENGINE=InnoDB;


CREATE TABLE Donation (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    donation_date DATE NOT NULL,
    volume_ml INT,
    event_id INT,
    remarks TEXT,

    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (event_id) REFERENCES Event(event_id)
) ENGINE=InnoDB;


DROP TABLE IF EXISTS Blood_Request;

CREATE TABLE Blood_Request (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    hospital_name VARCHAR(100) NOT NULL,
    blood_group_id INT,
    urgency_level VARCHAR(20),
    units_needed INT NOT NULL,
    needed_date DATE,
    status VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (blood_group_id) REFERENCES Blood_Group(blood_group_id)
) ENGINE=InnoDB;




CREATE TABLE Health_Screening (
    screening_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    hemoglobin_level DECIMAL(5,2),
    blood_pressure VARCHAR(20),
    eligibility_status VARCHAR(20),   -- eligible / not eligible
    notes TEXT,

    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (event_id) REFERENCES Event(event_id)
) ENGINE=InnoDB;



ALTER TABLE Users
ADD password VARCHAR(255) NOT NULL AFTER email;


INSERT INTO Role (role_name)
VALUES ('admin'), ('organizer'), ('user');

INSERT INTO designation (des_name)
VALUES ('student'), ('faculty'), ('staff');

INSERT INTO Blood_Group (blood_group)
VALUES ('A+'),('A-'),('B+'),('B-'),('AB+'),('AB-'),('O+'),('O-');


