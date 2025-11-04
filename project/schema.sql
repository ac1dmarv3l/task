CREATE TABLE products
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(255)           NOT NULL,
    description TEXT,
    category    VARCHAR(100)           NOT NULL,
    price       DECIMAL(10, 2)         NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image       VARCHAR(500),
    status      BOOLEAN   DEFAULT TRUE NOT NULL
);

CREATE TABLE users
(
    id       SERIAL PRIMARY KEY,
    email    VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);