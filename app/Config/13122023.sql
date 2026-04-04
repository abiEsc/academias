--
-- Implementacion de Sucursales y Segmentacion de Registros
--


--
-- Insercion de nuevo menu
--
INSERT INTO menu (menu_nombre, menu_descripcion, menu_enlace, menu_icono) VALUES ('Sucursales', 'Descripcion item menu - Gestion Sucursales', 'Gestion-Sucursales', 'bi bi-building');

--
-- Asignacion de Módulo para rol Gerente
--
INSERT INTO rol_menu (rol_id, menu_id) VALUES ('1', '8');


--
-- Creacion de Tabla Registro Sucursales
--
CREATE TABLE IF NOT EXISTS estructura_sucursal (
  sucursal_id INT(11) NOT NULL AUTO_INCREMENT,
  sucursal_nombre VARCHAR(100) NOT NULL,
  sucursal_activo INT(11) NOT NULL,
  accion_usuario INT(11) NOT NULL,
  accion_fecha DATETIME NOT NULL,
  PRIMARY KEY (sucursal_id),
  INDEX fk_usuario_sucursal_idx (accion_usuario ASC),
  CONSTRAINT fk_usuario_sucursal
    FOREIGN KEY (accion_usuario)
    REFERENCES usuario (usuario_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


INSERT INTO estructura_sucursal (sucursal_nombre, sucursal_activo, accion_usuario, accion_fecha) VALUES ('Sucursal Central', '1', '5', '2023-12-14 00:00:00.000000') 

--
-- Tabla para asignacion de sucursales a usuarios
--
ALTER TABLE usuario 
DROP FOREIGN KEY fk_sucursal_usuario;

ALTER TABLE usuario 
DROP COLUMN sucursal_id,
DROP INDEX fk_sucursal_usuario ;
;

ALTER TABLE estructura_sucursal 
CHANGE COLUMN sucursal_id sucursal_id INT(11) NOT NULL ;

CREATE TABLE IF NOT EXISTS usuario_sucursal (
  usuario_sucursal_id INT(11) NOT NULL AUTO_INCREMENT,
  usuario_id INT(11) NOT NULL,
  sucursal_id INT(11) NOT NULL,
  accion_usuario INT(11) NOT NULL,
  accion_fecha DATETIME NOT NULL,
  PRIMARY KEY (usuario_sucursal_id),
  INDEX fk_us_usuario_idx (usuario_id ASC),
  INDEX fk_us_sucursal_idx (sucursal_id ASC),
  INDEX fk_us_accion_idx (accion_usuario ASC),
  CONSTRAINT fk_us_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (usuario_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_us_sucursal
    FOREIGN KEY (sucursal_id)
    REFERENCES estructura_sucursal (sucursal_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_us_accion
    FOREIGN KEY (accion_usuario)
    REFERENCES usuario (usuario_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


ALTER TABLE inscripcion ADD sucursal_id INT NOT NULL DEFAULT '1' AFTER incripcion_id;

ALTER TABLE inscripcion ADD CONSTRAINT fk_sucursal_inscripcion FOREIGN KEY (sucursal_id) REFERENCES estructura_sucursal(sucursal_id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE articulo ADD sucursal_id INT NOT NULL DEFAULT '1' AFTER articulo_id;

ALTER TABLE articulo ADD CONSTRAINT fk_sucursal_articulo FOREIGN KEY (sucursal_id) REFERENCES estructura_sucursal(sucursal_id) ON DELETE NO ACTION ON UPDATE NO ACTION;