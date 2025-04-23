create database dietaApp1;
use dietaApp1;

-- Table: dietas
Create Table Dietas(
    Nombre varchar(100) PRIMARY KEY,
    Nutriente varchar(100),
    Valor_Calorico  varchar(100),
    Alogenos varchar(100),
    Cantidad_VP varchar(100),
    Peso_neto varchar(100),
    Peso_bruto  varchar(100)
)