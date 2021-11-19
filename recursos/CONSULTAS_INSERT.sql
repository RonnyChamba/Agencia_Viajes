# Tablas Fuertes
-- CLIENTES
-- EMPLEADOS
-- TIPO_TRANSPORTE
-- CONDUCTOR
-- TIPO VIAJE

# Tablas debiles
-- LICENCIA
-- TRANSPORTE
-- DESTINO
-- COMPRA
-- CANCELACION COMPRA
-- FACTURA
-- --------------------------------------------------------------
USE AGENCIA_VIAJES;


# --------------------------  INSERT EMPLEADOS ----------------------
INSERT INTO EMPLEADOS VALUES('1723774640', 'RONNY', 'CHAMBA', 'SANTO DOMINGO', 25, 'SOLTERO', '0989024536', 400);
INSERT INTO EMPLEADOS VALUES('1754532435', 'RENE', 'SANTOS', 'SANTO DOMINGO', 30, 'SOLTERO', '0989353232', 400);
SELECT * FROM EMPLEADOS;

# ------------------------- INSERT CLIENTES ---------------------------------------
INSERT INTO CLIENTES VALUES('0434354534', 'JANDRY', 'GAVILANEZ', 'SANTO DOMINGO', 25,'ECUATORIANA', 'SOLTERO', '0989084333', 'SECUNDARIA');
INSERT INTO CLIENTES VALUES('2345458497', 'MAYRA', 'MEJIA', 'SANTO DOMINGO', 30,  'ECUATORIANA','SOLTERO', '0909444403', 'PRIMARIA');
SELECT * FROM CLIENTES;

# ------------------------------ INSERT TIPO_TRANSPORTE -----------------------

INSERT INTO TIPO_TRANSPORTE VALUES (NULL, 'BUS', 30);
INSERT INTO TIPO_TRANSPORTE VALUES (NULL, 'BUSETA', 15);
SELECT * FROM TIPO_TRANSPORTE;

# ------------------------ INSERT CONDUCTOR ---------------------------
INSERT INTO CONDUCTOR VALUES ('0934561234', 'JUAN', 'MACIAS','0945678904');
INSERT INTO CONDUCTOR VALUES ('1344546562', 'PEDRO', 'GUERRERO','0954546464');
SELECT * FROM CONDUCTOR;


# ---------------------  INSERT TIPO_VIAJE -----------------
INSERT INTO TIPO_VIAJE VALUE (NULL, 'FAMILIAR', 'PARA LA FAMILIA DE MAXIMO 6 PERSONAS', 800);
INSERT INTO TIPO_VIAJE VALUE (NULL, 'PERSONAL', 'PARA UNA UNICA PERSONA', 200);
SELECT * FROM TIPO_VIAJE;

# ---------------------- INSERT  LICENCIA ----------------------------
 -- PARA UN CONDUCTOR
INSERT INTO LICENCIA VALUES (NULL, 'A', '2018-04-13', '2023-04-10', '0934561234');
INSERT INTO LICENCIA VALUES (NULL, 'D', '2015-07-22', '2020-07-20', '0934561234');
-- PARA OTRO CONDUCTOR
INSERT INTO LICENCIA VALUES (NULL, 'C', '2019-09-13', '2024-09-10', '1344546562');
INSERT INTO LICENCIA VALUES (NULL, 'D', '2020-02-22', '2025-02-20', '1344546562');

SELECT * FROM LICENCIA;

# ----------------------------- INSERT TRANSPORTE
INSERT INTO TRANSPORTE VALUES (NULL,'JKF-456', 'AMARILLO', '2013', 1, '0934561234');
INSERT INTO TRANSPORTE VALUES (NULL,'FID-099', 'GRIS', '2019', 2, '1344546562');
SELECT * FROM TRANSPORTE;

# - --------------------- INSERT  DESTINO
INSERT INTO DESTINO VALUES(NULL, 'PEDERNALES', 'VIA PERDERNALES Y JUANA PEREZ','MANABI', 'ECUADOR',1);
INSERT INTO DESTINO VALUES(NULL, 'ATACAMES', 'VIA ESMERALDAS Y PASAJE LOPEZ','ESMERALDAS', 'ECUADOR',2);
SELECT * FROM DESTINO;

# ----------------------------- INSERT COMPRA  ---------------------------------------
INSERT INTO COMPRA VALUES (NULL, CURDATE(), 1, '0434354534', 1, 1, '1723774640');
INSERT INTO COMPRA VALUES (NULL, CURDATE(), 1, '2345458497', 2, 2, '1754532435');
SELECT * FROM COMPRA;


# ----------------------- INSERTO CANCELAR_COMPRA


# ----------------------- INSERT FACTURA ------------------------------

INSERT INTO FACTURA VALUES (NULL, 'Ninguna', CURDATE(), 1,800,800);
INSERT INTO FACTURA VALUES (NULL, 'Ninguna', CURDATE(), 2,200,200);
SELECT * FROM COMPRA;