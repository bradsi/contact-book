-- just saving some sql queries in here for future reference

-- creating the contacts table
CREATE TABLE contacts (
    id INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_modified DATETIME ON UPDATE CURRENT_TIMESTAMP,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);