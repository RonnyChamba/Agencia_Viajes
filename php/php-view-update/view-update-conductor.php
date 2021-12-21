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
                required
                readonly
                 value="<?php echo  $arreglo['CONDUCTOR_CED']?>"
              
              />
            </div>
            <div class="row">
              <label for="nombres" class="form__label">Nombres:</label
              ><input
                type="text"
                class="form__input"
                name="nombres"
                id="nombres"
                value="<?php echo  $arreglo['CONDUCTOR_NOM']?>"
                required
                placeholder="Campo obligatorio"
              />
            </div>
            <div class="row">
              <label for="apellidos" class="form__label">Apellidos:</label
              ><input
                type="text"
                class="form__input"
                name="apellidos"
                id="apellidos"
                value="<?php echo  $arreglo['CONDUCTOR_APE']?>"
                required
                placeholder="Campo obligatorio"
              />
            </div>
            <div class="row">
              <label for="telefono" class="form__label">T&eacute;lefono</label
              ><input
                type="text"
                class="form__input"
                name="telefono"
                id="telefono"
                value="<?php echo  $arreglo['CONDUCTOR_TEL']?>"
              />
            </div>
            
            <div class="row col-2 row--flex">
              <div>
                <input type="submit" value="Actualizar" class="btn btn--send" />
                <input type="reset" value="Cancelar" class="btn btn--reset" />
              </div>
              <div>
                <input type="submit" value="Cerrar" class="btn btn--close" />
               
              </div>
      </div> 
    </div>
        