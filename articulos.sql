-- Tabla para artículos
CREATE TABLE articulos (
    id INT PRIMARY KEY AUTO_INCREMENT, -- Identificador único para cada artículo
    contenido TEXT NOT NULL            -- El contenido del artículo
);

-- Tabla para artículos comprados
CREATE TABLE articulos_comprados (
    id INT PRIMARY KEY AUTO_INCREMENT, -- Identificador único para cada registro de compra
    articulo_id INT NOT NULL,          -- Clave foránea que referencia el 'id' de la tabla 'articulos'
    usuario_id INT NOT NULL,           -- Identificador del usuario que compró el artículo (asumiendo que existiría una tabla 'usuarios')

    -- Definir la restricción de clave foránea
    FOREIGN KEY (articulo_id) REFERENCES articulos(id)
    -- ON DELETE CASCADE -- Opcional: Para eliminar registros de compra si se elimina un artículo
    -- ON UPDATE CASCADE -- Opcional: Para actualizar registros de compra si cambia el ID de un artículo
);

