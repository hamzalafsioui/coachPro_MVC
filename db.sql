
CREATE DATABASE coach_pro_mvc;
-- Connect after creation
-- \c coach_pro_mvc;

-- ========== TABLES =============

-- Roles
CREATE TABLE roles (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Users
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    role_id INT NOT NULL,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Coach profiles
CREATE TABLE coach_profiles (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    bio TEXT,
    experience_years INT,
    certifications TEXT,
    photo VARCHAR(255),
    rating_avg NUMERIC(3,2) DEFAULT 0.00,
    hourly_rate NUMERIC(10,2) DEFAULT 50.00,
    CONSTRAINT fk_coach_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);




-- Sportifs
CREATE TABLE sportifs (
    user_id INT PRIMARY KEY,
    CONSTRAINT fk_sportif_user
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sports
CREATE TABLE sports (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Coach  Sports
CREATE TABLE coach_sports (
    coach_id INT NOT NULL,
    sport_id INT NOT NULL,
    PRIMARY KEY (coach_id, sport_id),
    FOREIGN KEY (coach_id) REFERENCES coach_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (sport_id) REFERENCES sports(id) ON DELETE CASCADE
);

-- Availabilities
CREATE TABLE availabilities (
    id SERIAL PRIMARY KEY,
    coach_id INT NOT NULL,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (coach_id) REFERENCES coach_profiles(id) ON DELETE CASCADE
);

-- Recurring slots
CREATE TABLE coach_recurring_slots (
    id SERIAL PRIMARY KEY,
    coach_id INT NOT NULL,
    day_of_week VARCHAR(9) NOT NULL CHECK (
        day_of_week IN (
            'monday','tuesday','wednesday',
            'thursday','friday','saturday','sunday'
        )
    ),
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (coach_id) REFERENCES coach_profiles(id) ON DELETE CASCADE,
    UNIQUE (coach_id, day_of_week, start_time)
);

-- Statuses
CREATE TABLE statuses (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Reservations
CREATE TABLE reservations (
    id SERIAL PRIMARY KEY,
    sportif_id INT NOT NULL,
    coach_id INT NOT NULL,
    availability_id INT NOT NULL,
    status_id INT NOT NULL,
    price NUMERIC(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sportif_id) REFERENCES sportifs(user_id) ON DELETE CASCADE,
    FOREIGN KEY (coach_id) REFERENCES coach_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (availability_id) REFERENCES availabilities(id),
    FOREIGN KEY (status_id) REFERENCES statuses(id)
);

-- Reviews
CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    reservation_id INT NOT NULL UNIQUE,
    author_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES sportifs(user_id) ON DELETE CASCADE
);

-- Review replies
CREATE TABLE review_replies (
    id SERIAL PRIMARY KEY,
    review_id INT NOT NULL UNIQUE,
    coach_id INT NOT NULL,
    reply_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE CASCADE,
    FOREIGN KEY (coach_id) REFERENCES coach_profiles(id) ON DELETE CASCADE
);

-- Client plans
CREATE TABLE client_plans (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    price NUMERIC(10,2),
    duration_days INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Coach Clients
CREATE TABLE coach_clients (
    id SERIAL PRIMARY KEY,
    coach_id INT NOT NULL,
    sportif_id INT NOT NULL,
    plan_id INT,
    status VARCHAR(10) DEFAULT 'active'
        CHECK (status IN ('active','inactive','paused')),
    progress INT DEFAULT 0 CHECK (progress BETWEEN 0 AND 100),
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coach_id) REFERENCES coach_profiles(id) ON DELETE CASCADE,
    FOREIGN KEY (sportif_id) REFERENCES sportifs(user_id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES client_plans(id) ON DELETE SET NULL,
    UNIQUE (coach_id, sportif_id)
);


--              INSERT DATA

-- Roles
INSERT INTO roles (name) VALUES ('coach'), ('sportif');

-- Users
INSERT INTO users (role_id, firstname, lastname, email, password, phone) VALUES
(1,'Hamza','Lafsioui','hamza.coach@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0612345678'),
(1,'John','Doe','john.doe@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0600000001'),
(1,'Alice','Smith','alice.smith@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0600000002'),
(1,'Michael','Brown','michael.brown@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0600000003'),
(1,'Sarah','Wilson','sarah.wilson@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0600000004'),
(2,'Sara','Sportif','sara.sportif@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0698765432'),
(2,'Bob','Johnson','bob.johnson@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0698765433'),
(2,'Emma','Davis','emma.davis@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0698765434'),
(2,'James','Miller','james.miller@email.com','$2y$12$rJsON6G/CBvfvR26cSQeGu1lOJRjWQZEHxGiyZIcVQvzb4uajXEjG','0698765435');

-- Coach profiles
INSERT INTO coach_profiles (user_id,bio,experience_years,certifications,photo,rating_avg) VALUES
(1,'Fitness & HIIT coach',5,'CPT, Crossfit L1','hamza.jpg',4.80),
(2,'Tennis coach',8,'ATP, USPTA','john.jpg',4.50),
(3,'Yoga instructor',3,'RYT 200','alice.jpg',4.90),
(4,'Basketball coach',6,'USA Basketball','michael.jpg',4.75),
(5,'Cardio coach',4,'Running Coach','sarah.jpg',4.85);

-- Sportifs
INSERT INTO sportifs VALUES (6),(7),(8),(9);

-- Sports
INSERT INTO sports (name) VALUES
('Football'),('Fitness'),('Yoga'),('Tennis'),
('Basketball'),('Padel'),('Cardio'),
('Strength Training'),('HIIT'),('Crossfit');

-- Coach sports
INSERT INTO coach_sports VALUES
(1,2),(1,8),(1,9),
(2,4),(2,6),
(3,3),(3,2),
(4,5),(4,2),
(5,7),(5,2),(5,9);

-- Statuses
INSERT INTO statuses (name)
VALUES ('pending'),('confirmed'),('completed'),('cancelled');

-- availabilty
INSERT INTO availabilities (coach_id, date, start_time, end_time, is_available)
VALUES (1, '2026-01-20', '08:00:00', '10:00:00', TRUE);

-- Reservation
INSERT INTO reservations (sportif_id, coach_id, availability_id, status_id, price, created_at)
VALUES
(6, 1, 1, 1, 100.00, CURRENT_TIMESTAMP);
