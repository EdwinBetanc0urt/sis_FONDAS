<div id="VentanaModal" class="modal fade modal-primary">
	<form id="formRecuperarClave" name="formRecuperarClave" method="POST" autocomplete="off" 
		action="controlador/conRecuperarClave.php" role="form" class="form-horizontal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">
						X
					</button>
					<h2 class="modal-title"> RECUPERAR CONTRASEÑA</h2>
				</div>

				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group ui-front">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label for="ctxUsuario">* Usuario</label>
								<input id="ctxUsuario" class="valida_numerico form-control"
									maxlength="45" name="ctxUsuario" type="text" required
									placeholder="Ingrese el usuario"data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta">* Pregunta 1</label>
								<select id='cmbPregunta' name='cmbPregunta' size="1"
									data-placement="right" title="Selecciona una opción"
									class="dinamico form-control select2" data-toggle="tooltip">
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta" type="hidden" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta">* Respuesta 1</label>
								<input id="ctxRespuesta" class=" form-control" maxlength="45"
									name="ctxRespuesta1" type="text" required
									placeholder="Ingrese la primera respuesta"
									data-toggle="tooltip"	data-placement="right"
									title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="cmbPregunta2">* Pregunta 2</label>
								<select id='cmbPregunta2' name='cmbPregunta2' size="1"
								data-toggle="tooltip"	class="dinamico form-control select2"
								data-placement="right" title="Selecciona una opción" >
									<option value="">Selecciona Uno...</option>
								</select>
								<input id="hidPregunta2" type="hidden"	/>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="ctxRespuesta2">* Respuesta 2</label>
								<input id="ctxRespuesta2" class="form-control" maxlength="45"
									name="ctxRespuesta2" type="text" data-toggle="tooltip"
									placeholder="Ingrese la segunda respuesta" required
									data-placement="right" title="Campo Obligatorio" />
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave">* Ingresar Clave Nueva</label>
								<input id="pswClave" name="pswClave" type="password" required
									maxlength="45" class="form-control valida_clave new-password"
									placeholder="Ingrese la Clave" data-toggle="tooltip"
									data-placement="right" title="Campo Obligatorio" />
								<div class="divItemsClave">
									<p id="claveMinuscula" class="invalido">
										Al menos <strong>1 letra en minúscula (a-z)</strong>
									</p>
									<p id="claveMayuscula" class="invalido">
										Al menos <strong>1 letra en MAYUSCULA(A-Z)</strong>
									</p>
									<p id="claveNumero" class="invalido">
										Al menos <strong>1 numero (0-9)</strong>
									</p>
									<p id="claveEspecial" class="invalido">
										Al menos <strong>1 carácter especial (_.-+*$)</strong>
									</p>
									<p id="claveLongitud" class="invalido">
										Longitud min. de <strong>8 caracteres</strong>
									</p>
								</div>
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<label for="pswClave2">* Confirmar Clave Nueva</label>
								<input id="pswClave2" type="password" required
									maxlength="45"  class="form-control confirm-password"
									placeholder="Confirme la clave" data-placement="right"
									data-toggle="tooltip" title="Campo Obligatorio" />
							</div>

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<div class="row" >
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							<button type="button" value="RecuperarClave"
								style="background:#37474F; color:#fff;" 
								class="form-control" onclick="enviar(this.value);">
								ENVIAR
							</button>
						</div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
					</div>
				</div>

			</div>
		</div>

		<input type="hidden" name="operacion" id="operacion" value="RecuperarClave" />
	</form>
</div>