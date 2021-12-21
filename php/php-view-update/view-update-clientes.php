<?php
// Recibir objeto como string
$data = $_GET['data'];

// Convertir
$arreglo = json_decode($data, true);
?>

<div class="form-content form-content--grid">
      <div class="row">
              <label for="cedula" class="form__label">C&eacute;dula:</label
              ><input
                type="text"
                class="form__input"
                name="cedula"
                id="cedula"
                readonly
                value="<?php echo  $arreglo['CLIENTES_CED']?>"
                required
                
              />
      </div>
      <div class="row">
              <label for="nombres" class="form__label">Nombres:</label
              ><input
                type="text"
                class="form__input"
                name="nombres"
                id="nombres"
                value="<?php echo  $arreglo['CLIENTES_NOM']?>"
                required
                placeholder=" Campo Obligatorio"
              />
      </div>
      <div class="row">
              <label for="apellidos" class="form__label">Apellidos:</label
              ><input
                type="text"
                class="form__input"
                name="apellidos"
                id="apellidos"
                value="<?php echo  $arreglo['CLIENTES_APE']?>"
                required
                placeholder=" Campo Obligatorio"
              />
      </div>
      <div class="row">
              <label for="direccion" class="form__label"
                >Direcci&oacute;n:</label
              ><input
                type="text"
                class="form__input"
                id="direccion"
                value="<?php echo  $arreglo['CLIENTES_DIR']?>"
                name="direccion"
              />
      </div>
      <div class="row">
              <label for="edad" class="form__label">Edad:</label
              >
              <input 
              type="number" 
              class="form__input" 
              name="edad"
              value="<?php echo  $arreglo['CLIENTES_EDA']?>" 
              id="edad" />
      </div>

      <div class="row">
              <label for="nacionalidad" class="form__label">
                Nacionalidad:</label
              ><input
                type="text"
                class="form__input"
                id="nacionalidad"
                name="nacionalidad"
                value="<?php echo  $arreglo['CLIENTES_NAC']?>"
              />
      </div>
      <div class="row">
              <label for="estado" class="form__label">Estado civil:</label>
              <select name="estado" id="estado">
                <option value="SOLTERO"
                 <?php  echo $arreglo['CLIENTES_ES_C']=="SOLTERO"? 'selected':''?>
                >Soltero</option>
                <option value="CASADO"
                <?php  echo $arreglo['CLIENTES_ES_C']=="CASADO"? 'selected':''?> 
                >Casado</option>
                <option value="VIUDO"
                 <?php echo $arreglo['CLIENTES_ES_C']=="VIUDO"? 'selected':''?> 
                >Viudo</option>
              </select>
      </div>

      <div class="row">
              <label for="telefono" class="form__label">T&eacute;lefono</label
              ><input
                type="text"
                class="form__input"
                name="telefono"
                id="telefono"
                   value="<?php echo  $arreglo['CLIENTES_TEL']?>"
              />
      </div>
            <div class="row col-2">
              <label for="estudios" class="form__label"
                >Estudios realizados:</label
              ><input
                type="text"
                class="form__input"
                name="estudios"
                id="estudios"
                   value="<?php echo  $arreglo['CLIENTES_ES_R']?>"
              />
      </div>
      <div class="row col-2 row--flex">
              <div>
                <input type="submit" value="Actualizar" class="btn btn--send" />
                <input type="reset" value="Cancelar" class="btn btn--reset" />
              </div>
              <div>
                <p class="btn btn--close" id="modal-close">Cerrar</p>
               
              </div>
      </div>  
  </div>
       