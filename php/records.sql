CREATE TABLE IF NOT EXISTS registro(
    user_name VARCHAR(50) NOT NULL,
    user_surname VARCHAR(50) NOT NULL,
    user_time INT NOT NULL,
    game_level VARCHAR(10) NOT NULL CHECK (game_level IN ('Fácil', 'Medio', 'Difícil')),
    PRIMARY KEY (user_name,user_surname, user_time, game_level)
);