-- Crear tabla de alumnos
CREATE TABLE alumnos (
  id_alumno INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellido VARCHAR(50) NOT NULL,
  etapa ENUM('Primaria', 'ESO', 'Bachillerato') NOT NULL,
  curso VARCHAR(10) NOT NULL,
  grupo VARCHAR(5),
  fecha_nacimiento DATE
);

-- Crear tabla de notas
CREATE TABLE notas (
  id_nota INT AUTO_INCREMENT PRIMARY KEY,
  id_alumno INT NOT NULL,
  asignatura VARCHAR(50) NOT NULL,
  evaluacion ENUM('1ª', '2ª', '3ª') NOT NULL,
  nota VARCHAR(20) NOT NULL,
  FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno) ON DELETE CASCADE
);
