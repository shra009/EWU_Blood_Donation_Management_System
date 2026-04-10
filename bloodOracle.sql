CREATE TABLE users (
    user_id NUMBER PRIMARY KEY,
    name VARCHAR2(100) NOT NULL,
    email VARCHAR2(100) UNIQUE NOT NULL,
    phone VARCHAR2(20),
    role VARCHAR2(20),
    blood_group VARCHAR2(5),
    dob DATE,
    gender VARCHAR2(10)
);

CREATE TABLE event (
    event_id NUMBER PRIMARY KEY,
    organizer_id NUMBER NOT NULL,
    event_name VARCHAR2(100),
    event_date DATE,
    location VARCHAR2(100),
    description VARCHAR2(500),

    CONSTRAINT fk_event_organizer
        FOREIGN KEY (organizer_id)
        REFERENCES users(user_id)
);

CREATE TABLE eligibility (
    eligibility_id NUMBER PRIMARY KEY,
    user_id NUMBER NOT NULL,
    last_donation_date DATE,
    next_eligible_date DATE,
    health_status VARCHAR2(50),
    weight NUMBER(5,2),
    hemoglobin_level NUMBER(5,2),
    eligibility_flag VARCHAR2(20),
    notes VARCHAR2(500),
    event_id NUMBER,

    CONSTRAINT fk_eligibility_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id),

    CONSTRAINT fk_eligibility_event
        FOREIGN KEY (event_id)
        REFERENCES event(event_id)
);

CREATE TABLE donation (
    donation_id NUMBER PRIMARY KEY,
    user_id NUMBER NOT NULL,
    donation_date DATE NOT NULL,
    volume_ml NUMBER,
    event_id NUMBER,
    remarks VARCHAR2(500),

    CONSTRAINT fk_donation_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id),

    CONSTRAINT fk_donation_event
        FOREIGN KEY (event_id)
        REFERENCES event(event_id)
);

CREATE TABLE blood_request (
    request_id NUMBER PRIMARY KEY,
    user_id NUMBER NOT NULL,
    blood_group VARCHAR2(5),
    urgency_level VARCHAR2(20),
    needed_date DATE,
    status VARCHAR2(20),

    CONSTRAINT fk_request_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);

CREATE TABLE request_donor_match (
    match_id NUMBER PRIMARY KEY,
    request_id NUMBER NOT NULL,
    user_id NUMBER NOT NULL,
    match_status VARCHAR2(30),

    CONSTRAINT fk_match_request
        FOREIGN KEY (request_id)
        REFERENCES blood_request(request_id),

    CONSTRAINT fk_match_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id)
);

CREATE TABLE health_screening (
    screening_id NUMBER PRIMARY KEY,
    user_id NUMBER NOT NULL,
    event_id NUMBER NOT NULL,
    hemoglobin_level NUMBER(5,2),
    blood_pressure VARCHAR2(20),
    eligibility_status VARCHAR2(20),
    notes VARCHAR2(500),

    CONSTRAINT fk_screening_user
        FOREIGN KEY (user_id)
        REFERENCES users(user_id),

    CONSTRAINT fk_screening_event
        FOREIGN KEY (event_id)
        REFERENCES event(event_id)
);
