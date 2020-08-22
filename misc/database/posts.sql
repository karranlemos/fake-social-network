CREATE TABLE posts (
    id INT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT(10) UNSIGNED,
    title TINYTEXT,
    media TEXT,
    post_text TEXT,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user)
        REFERENCES users(id)
        ON DELETE SET NULL
);