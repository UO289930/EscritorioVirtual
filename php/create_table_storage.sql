CREATE TABLE category (
    category_id INT AUTO_INCREMENT,
    category_name VARCHAR(255) UNIQUE,
    PRIMARY KEY (category_id)
);

CREATE TABLE supplier (
    supplier_id INT AUTO_INCREMENT,
    supplier_name VARCHAR(255) UNIQUE,
    PRIMARY KEY (supplier_id)
);

CREATE TABLE product (
    product_id INT AUTO_INCREMENT,
    product_name VARCHAR(255) UNIQUE,
    product_price DECIMAL(10,2),
    category_id INT,
    supplier_id INT,
    FOREIGN KEY (category_id) REFERENCES category(category_id),
    FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id),
    PRIMARY KEY (product_id)
);

CREATE TABLE delivery_company (
    company_id INT AUTO_INCREMENT,
    company_name VARCHAR(255) UNIQUE,
    PRIMARY KEY (company_id)
);

CREATE TABLE delivery_worker (
    worker_id INT AUTO_INCREMENT,
    worker_dni VARCHAR(50) UNIQUE,
    worker_name VARCHAR(255),
    worker_surname VARCHAR(255),
    company_id INT,
    FOREIGN KEY (company_id) REFERENCES delivery_company(company_id),
    PRIMARY KEY (worker_id)
);

CREATE TABLE is_delivered (
    delivery_id INT AUTO_INCREMENT,
    delivery_date VARCHAR(20),
    product_id INT,
    product_quantity INT,
    worker_id INT,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (worker_id) REFERENCES delivery_worker(worker_id),
    PRIMARY KEY (delivery_id)
);