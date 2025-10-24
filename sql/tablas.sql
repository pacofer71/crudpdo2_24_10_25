-- Creamos la tabla de usuarios
CREATE TABLE Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Creamos la tabla de productos
CREATE TABLE Producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    precio DECIMAL(6,2) CHECK (precio >= 0 AND precio <= 9999.99),
    disponible ENUM('SI', 'NO') DEFAULT 'SI',
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);