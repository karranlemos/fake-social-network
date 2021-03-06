CREATE TABLE users_authentication (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT(10) UNSIGNED NOT NULL,
    token BLOB(256) NOT NULL,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user)
        REFERENCES users(id)
        ON DELETE CASCADE
);