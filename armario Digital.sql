create database Armario_Digital;
use Armario_Digital;


create TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    user_type VARCHAR(20) NOT NULL CHECK (user_type IN ('cliente', 'empresa')),
    cpf_cnpj VARCHAR(20) UNIQUE,
    profile_picture_url VARCHAR(255),
    bio TEXT,
    followers_count INTEGER DEFAULT 0,
    following_count INTEGER DEFAULT 0,
    posts_count INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de seguidores (relacionamento entre usuários)
CREATE TABLE user_follows (
    follower_id BIGINT UNSIGNED NOT NULL,
    followed_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_follower FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_followed FOREIGN KEY (followed_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT user_follows_pk PRIMARY KEY (follower_id, followed_id)
);


-- Tabela de categorias de roupas
CREATE TABLE clothing_categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL
);

-- Tabela de peças de roupa
CREATE TABLE clothes_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    color VARCHAR(30),
    size VARCHAR(10),
    brand VARCHAR(50),
    image_url VARCHAR(255) NOT NULL,
    description TEXT,
    is_for_sale BOOLEAN DEFAULT FALSE,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES clothing_categories(id)
);

-- Tabela de looks (combinações de roupas)
CREATE TABLE looks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de junção entre looks e roupas (muitos-para-muitos)
CREATE TABLE look_items (
    look_id INTEGER NOT NULL,
    item_id INTEGER NOT NULL,
    PRIMARY KEY (look_id, item_id),
    FOREIGN KEY (look_id) REFERENCES looks(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES clothes_items(id) ON DELETE CASCADE
);

-- Tabela de eventos do calendário (agenda de looks)
CREATE TABLE look_items (
    look_id BIGINT UNSIGNED NOT NULL,
    item_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (look_id, item_id),
    FOREIGN KEY (look_id) REFERENCES looks(id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES clothes_items(id) ON DELETE CASCADE
);

-- Tabela de eventos no calendário
CREATE TABLE calendar_events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    look_id BIGINT UNSIGNED NOT NULL,
    event_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (look_id) REFERENCES looks(id) ON DELETE SET NULL
);

-- Tabela de mensagens
CREATE TABLE messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sender_id BIGINT UNSIGNED NOT NULL,
    receiver_id BIGINT UNSIGNED NOT NULL,
    content TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de denúncias
CREATE TABLE reports (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    reporter_id BIGINT UNSIGNED NOT NULL,
    reported_user_id BIGINT UNSIGNED,
    reported_item_id BIGINT UNSIGNED,
    reason VARCHAR(255) NOT NULL,
    description TEXT,
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'reviewed', 'dismissed')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reporter_id) REFERENCES users(id),
    FOREIGN KEY (reported_user_id) REFERENCES users(id),
    FOREIGN KEY (reported_item_id) REFERENCES clothes_items(id)
);