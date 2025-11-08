-- Crear tabla de asignaturas
CREATE TABLE IF NOT EXISTS asignaturas (
  id_asignatura INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  etapa VARCHAR(50) NOT NULL
);

-- Insertar asignaturas por etapa
INSERT INTO asignaturas (nombre, etapa) VALUES
('Matemáticas', 'Primaria'),
('Lengua', 'Primaria'),
('Ciencias', 'Primaria'),
('Inglés', 'Primaria'),
('Educación Física', 'Primaria'),

('Matemáticas', 'ESO'),
('Lengua Castellana', 'ESO'),
('Física y Química', 'ESO'),
('Geografía e Historia', 'ESO'),
('Tecnología', 'ESO'),

('Matemáticas', 'Bachillerato'),
('Filosofía', 'Bachillerato'),
('Biología', 'Bachillerato'),
('Historia del Arte', 'Bachillerato'),
('Economía', 'Bachillerato');
