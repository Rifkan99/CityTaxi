-- Table: SystemUsers
CREATE TABLE SystemUsers (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Name VARCHAR(255) NOT NULL,
    Role ENUM('ADMIN', 'EMPLOYEE') DEFAULT 'ADMIN'
);

-- Table: Drivers
CREATE TABLE Drivers (
    DriverID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(15) NOT NULL,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    NIC VARCHAR(15) NOT NULL,
    Licence VARCHAR(20) NOT NULL,
    AccountStatus ENUM('PENDING', 'ACTIVE', 'REJECTED', 'DISABLED') DEFAULT 'PENDING',
    Availability ENUM('AVAILABLE', 'BUSY', 'OFFLINE') DEFAULT 'OFFLINE',
    RegistrationTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Added RegistrationTime column
);

-- Table: Passengers
CREATE TABLE Passengers (
    PassengerID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(255) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(15) NOT NULL,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    AccountStatus ENUM('ACTIVE', 'DISABLED') DEFAULT 'ACTIVE',
    RegistrationTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Added RegistrationTime column
);

-- Table: Vehicles
CREATE TABLE Vehicles (
    VehicleID INT PRIMARY KEY AUTO_INCREMENT,
    DriverID INT,
    Model VARCHAR(255) NOT NULL,
    Latitude DECIMAL(10, 8) NOT NULL,
    Longitude DECIMAL(11, 8) NOT NULL,
    FOREIGN KEY (DriverID) REFERENCES Drivers(DriverID)
);

-- Table: UnregisteredCustomers
CREATE TABLE UnregisteredCustomers (
    UnregisteredCustomerID INT PRIMARY KEY AUTO_INCREMENT,
    Phone VARCHAR(15) NOT NULL,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL
);

-- Table: Reservations
CREATE TABLE Reservations (
    ReservationID INT PRIMARY KEY AUTO_INCREMENT,
    DriverID INT,
    PassengerID INT,
    UnregisteredCustomerID INT,
    VehicleID INT,
    ReservationTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    StartLatitude DECIMAL(10, 8) NOT NULL,
    StartLongitude DECIMAL(11, 8) NOT NULL,
    EndLatitude DECIMAL(10, 8) NOT NULL,
    EndLongitude DECIMAL(11, 8) NOT NULL,
    Status ENUM('PENDING', 'CONFIRMED', 'COMPLETED') DEFAULT 'PENDING',
    RatingScore INT,
    RatingComment TEXT,
    FOREIGN KEY (DriverID) REFERENCES Drivers(DriverID),
    FOREIGN KEY (PassengerID) REFERENCES Passengers(PassengerID),
    FOREIGN KEY (UnregisteredCustomerID) REFERENCES UnregisteredCustomers(UnregisteredCustomerID),
    FOREIGN KEY (VehicleID) REFERENCES Vehicles(VehicleID)
);


-- Table: Payments
CREATE TABLE Payments (
    PaymentID INT PRIMARY KEY AUTO_INCREMENT,
    ReservationID INT,
    Amount DECIMAL(10, 2) NOT NULL,
    Status ENUM('SUCCESS', 'FAILED') DEFAULT 'FAILED',
    Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ReservationID) REFERENCES Reservations(ReservationID)
);