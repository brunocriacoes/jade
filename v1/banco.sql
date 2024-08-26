CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    publicId VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    status VARCHAR(50)
);

CREATE TABLE store (
    id INT AUTO_INCREMENT PRIMARY KEY,
    publicId VARCHAR(255) NOT NULL,
    externalId VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    status VARCHAR(50),
    walletId VARCHAR(255),
    asaasApiKey VARCHAR(255),
    blingClientId VARCHAR(255),
    blingClientSecret VARCHAR(255),
    blingToken VARCHAR(255),
    blingRefreshToken VARCHAR(255)
);

CREATE TABLE webhook (
    id INT AUTO_INCREMENT PRIMARY KEY,
    storePublicId VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    value DECIMAL(10, 2),
    status VARCHAR(50),
    origin VARCHAR(255),
    paymentKey VARCHAR(255),
    payload JSON
);

CREATE TABLE payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customerId VARCHAR(255) NOT NULL,
    storePublicId VARCHAR(255) NOT NULL,
    externalId VARCHAR(255) NOT NULL,
    paymentId VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    value DECIMAL(10, 2),
    status VARCHAR(255)
);

CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customerId VARCHAR(255) NOT NULL,
    storePublicId VARCHAR(255) NOT NULL,
    date DATETIME NOT NULL,
    name VARCHAR(255) NOT NULL,
    cpfCnpj VARCHAR(255),
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL
);