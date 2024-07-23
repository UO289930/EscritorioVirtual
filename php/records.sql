CREATE TABLE IF NOT EXISTS registro(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    user_surname VARCHAR(50) NOT NULL,
    user_time INT NOT NULL,
    game_level VARCHAR(10) NOT NULL CHECK (game_level IN ('Fácil', 'Medio', 'Difícil'))
);