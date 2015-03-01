CREATE TABLE comment
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    customer INT NOT NULL,
    product INT NOT NULL,
    text LONGTEXT NOT NULL,
    rating REAL NOT NULL,
    FOREIGN KEY (product) REFERENCES product (id) ON DELETE CASCADE,
    FOREIGN KEY (customer) REFERENCES user (id) ON DELETE CASCADE
);
CREATE TABLE event
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    description LONGTEXT NOT NULL,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE exemplar
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    size VARCHAR(255) NOT NULL,
    product INT NOT NULL,
    FOREIGN KEY (product) REFERENCES product (id) ON DELETE CASCADE
);
CREATE TABLE order_exemplar
(
    orderid INT NOT NULL,
    exemplar INT NOT NULL,
    FOREIGN KEY (orderid) REFERENCES order_list (id) ON DELETE CASCADE,
    FOREIGN KEY (exemplar) REFERENCES exemplar (id) ON DELETE CASCADE
);
CREATE TABLE order_list
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user INT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    FOREIGN KEY (user) REFERENCES user (id) ON DELETE CASCADE
);
CREATE TABLE product
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description LONGTEXT NOT NULL,
    price REAL NOT NULL,
    shipping REAL NOT NULL,
    gender CHAR(7) NOT NULL,
    type CHAR(9) NOT NULL
);
CREATE TABLE product_event
(
    product INT NOT NULL,
    event INT NOT NULL,
    FOREIGN KEY (product) REFERENCES product (id) ON DELETE CASCADE,
    FOREIGN KEY (event) REFERENCES event (id) ON DELETE CASCADE
);
CREATE TABLE product_image
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    url VARCHAR(1024) NOT NULL,
    product INT NOT NULL,
    FOREIGN KEY (product) REFERENCES product (id) ON DELETE CASCADE
);
CREATE TABLE product_theme
(
    product INT NOT NULL,
    theme INT NOT NULL,
    FOREIGN KEY (product) REFERENCES product (id) ON DELETE CASCADE,
    FOREIGN KEY (theme) REFERENCES theme (id) ON DELETE CASCADE
);
CREATE TABLE recommend
(
    product1 INT NOT NULL,
    product2 INT NOT NULL,
    FOREIGN KEY (product1) REFERENCES product (id) ON DELETE CASCADE,
    FOREIGN KEY (product2) REFERENCES product (id) ON DELETE CASCADE
);
CREATE TABLE theme
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description LONGTEXT NOT NULL
);
CREATE TABLE user
(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    gender CHAR(6) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT NOT NULL
);
