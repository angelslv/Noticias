<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Panel de Administración - Seguimiento por Git</title>
		<meta charset="UTF-8" />
	    <meta name="description" content="Práctica 2 - TIII" />
	    <meta name="keywords" content="HTML5, CSS3, GIT, GITHUB, PHP, MARIADB " />
	    <meta name="author" content="Dr. Ángel Vásquez" />

		<!-- INICIAN ETIQUETAS NUEVAS -->
    	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" />
    	<meta name="robots" content="index, follow" />
   		 <!-- TERMINAN ETIQUETAS NUEVAS -->

		<!-- Utilizando framework de bootstrap & la fuente de fontawesome -->
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="font-awesome/4.5.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/css-git.css" />

		<!-- fuentes para el texto usando apis de google -->
		<link rel="stylesheet" href="css/fonts.googleapis.com.css" />

		<!-- hoja de estilo 'ace' para forma -->
		<link rel="stylesheet" href="css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="css/ace-skins.min.css" />
		<link rel="stylesheet" href="css/ace-rtl.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/sweetalert.min.js"></script>
		<script type="text/javascript" src="../js/sweetalert.min.js"></script>
		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="css/ace-ie.min.css" />
		<![endif]-->

		<!-- estilos relativos de la página-->

		<!-- Archivo de javascript para 'ace'-->
		<script src="js/ace-extra.min.js"></script>

		<!-- Archivos HTML5shiv y Respond.js para el soporte de HTML5 sobre elementos de IE8 y el uso de media queries de css -->

		<!--[if lte IE 8]>
		<script src="js/html5shiv.min.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>

<body class="no-skin">
    <?php
		session_start();
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		
		} else {
		?>
		<script>
			swal({
		    			title: "Acceso restringido!",
		    			text: "Esta pagina es exclusiva para usuarios registrados",
		    			type: "error",
		    			showCancelButton:true,
		    			confirmButtonColor: "#DD6B55",
		    			confirmButtonText: "Registrarse",
		    			cancelButtonText: "Salir",
		    			closeOnConfirm: false,
		    			closeOnCancel: false},
		    			function(isConfirm){
		    				if(isConfirm){
		    					swal({title: "Redireccionando",text: "registro de usuarios",type: "success"},function(){
		    							window.location.href = '../alta_usuario.html';		  	
		    						  });	
		    				}else{
		    					window.location.href = '../index.html';
		    				}
		    			});
		</script>
		<?php
	}
    ?>
	<!-- Ventana modal para perfil de usuario -->

  <!-- Trigger the modal with a button -->

  <!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="padding:35px 50px;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 id="titulo_modal"><span class="glyphicon glyphicon-lock"></span> Perfil</h4>
			</div>
			<div class="modal-body" style="padding:40px 50px;">
			<form role="form">
				<div class="form-group">
				<label for="usrname"><span class="glyphicon glyphicon-user"></span>Nombre</label>
				<input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
				</div>
				<div class="form-group">
				<label for="usrname"><span class="glyphicon glyphicon-user"></span> Apellidos</label>
				<input type="text" class="form-control" id="apellidos" placeholder="Apellidos" required>
				</div>
				<div class="form-group">
				<label for="usrname"><span class="glyphicon glyphicon-user"></span> Nombre de usuario</label>
				<input type="text" class="form-control" id="usuario" placeholder="Usuario" required>
				</div>
				<div class="form-group">
				<label for="usrname"><span class="glyphicon glyphicon-user"></span>Correo electronico</label>
				<input type="text" class="form-control" id="email" placeholder="email" required>
				</div>
				<div class="form-group">
				<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
				<input type="password" class="form-control" id="password" placeholder="********" required>
				</div>
				<div class="form-group">
				<label for="psw"><span class="glyphicon glyphicon-eye-open"></span>Confirmar password</label>
				<input type="password" class="form-control" id="password2" placeholder="********" required>
				</div>
				<button type="submit" class="btn btn-success btn-block" id="enviar_datos"><span class="glyphicon glyphicon-off"></span>Aceptar</button>
			</form>
			</div>
			<div class="modal-footer">
			<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
			</div>
		</div>
		
		</div>
	</div> 
	
	<script>
		$(document).ready(function(){
			var altas;
			$("#myBtn").click(function(){
				$.ajax({
					data: {"idUsuario" : <?php echo "{$_SESSION['userId']}";?>,"op":'1'},
					dataType: "json",
					url: "http://localhost/Noticias/administracion/perfil.php",
					type: "POST",
					success:  function (response) {
						$("#nombre").val(response.usuario.nombre);
						$("#apellidos").val(response.usuario.apellidos);
						$("#usuario").val(response.usuario.usuario);
						$("#email").val(response.usuario.email);
						$("#password").val(response.usuario.password);
						$("#password2").val(response.usuario.password);
					}
				});
				$("#myModal").modal();
				altas = 1;
			});
			$("#enviar_datos").click(function(){
				if (altas ==1){
					if($("#password").val() === $("#password2").val()){
						
						var nombre = $("#nombre").val();
						var apellidos = $("#apellidos").val();
						var usuario = $("#usuario").val();
						var email = $("#email").val();
						var password = $("#password").val();
						$.ajax({
						data: {"idUsuario" : <?php echo "{$_SESSION['userId']}";?>,"op":'2',"nombre":nombre,"apellidos":apellidos,"usuario":usuario,"email":email,"password":password},
						url: "http://localhost/Noticias/administracion/perfil.php",
						type: "POST",
						success:  function (response) {
							console.log(response);
							swal({title: "Usuario",text: "Datos actualizados correctamente",type: "success"});
						},
						error: function(response){
							console.log(response);
						}
					});
					}else{
						swal({title: "Password",text: "Las contraseñas no coinciden",type: "warning"});
					}
				}else if(altas ==2){
						url = "http://localhost/Noticias/Modelo/altas.php";
						titulo = "Administrador";
						mensaje = "Administrador agregado correctamente";
						altaUsuario(url,titulo,mensaje);
				}
				else if(altas ==3){
						url = "http://localhost/Noticias/Modelo/altas.php";
						titulo = "Cliente";
						mensaje = "cliente agregado correctamente";
						altaUsuario(url,titulo,mensaje);
				}

			});

			$("#altas_admin").click(function(){
				$("#titulo_modal").text("Alta de administradores");
				$("#myModal").modal();
				altas = 2;
			});

			function altaUsuario(url,titulo,mensaje){
				if($("#password").val() === $("#password2").val()){
					var nombre = $("#nombre").val();
					var apellidos = $("#apellidos").val();
					var usuario = $("#usuario").val();
					var email = $("#email").val();
					var password = $("#password").val();
					$.ajax({
					data: {"op":'1',"nombre":nombre,"apellidos":apellidos,"usuario":usuario,"email":email,"password":password},
					url: url,
					type: "POST",
					success:  function (response) {
						console.log(response);
						swal({title: titulo,text: mensaje,type: "success"});
					},
					error: function(response){
						console.log(response);
					}
				});
				}else{
					swal({title: "Password",text: "Las contraseñas no coinciden",type: "warning"});
				}
			}

		});
	</script>

	<!-- -Inicia contenedor o div azul superior -->
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Menú</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.php" class="navbar-brand">
						<small>
							<i class="fa "></i>
							Panel de Administración
						</small>
					</a>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="grey dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-tasks"></i>
								<span class="badge badge-grey">4</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-check"></i>
									4 tareas completas
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Actualización de software</span>
													<span class="pull-right">65%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:65%" class="progress-bar"></div>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Actualización de Hardware</span>
													<span class="pull-right">35%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:35%" class="progress-bar progress-bar-danger"></div>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Pruebas de Unidad</span>
													<span class="pull-right">15%</span>
												</div>

												<div class="progress progress-mini">
													<div style="width:15%" class="progress-bar progress-bar-warning"></div>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">Configuración de e-mail</span>
													<span class="pull-right">90%</span>
												</div>

												<div class="progress progress-mini progress-striped active">
													<div style="width:90%" class="progress-bar progress-bar-success"></div>
												</div>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										Ver más detalles
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="purple dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important">8</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-exclamation-triangle"></i>
									8 Notificaciones
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar navbar-pink">
										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
														Comentarios nuevos
													</span>
													<span class="pull-right badge badge-info">+12</span>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<i class="btn btn-xs btn-primary fa fa-user"></i>
												.
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
														Nuevas ordenes de compra
													</span>
													<span class="pull-right badge badge-success">+8</span>
												</div>
											</a>
										</li>

										<li>
											<a href="#">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
														Seguidores por Twitter
													</span>
													<span class="pull-right badge badge-info">+11</span>
												</div>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="#">
										Ver todas las notificaciones
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="green dropdown-modal">
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
								<span class="badge badge-success">5</span>
							</a>

							<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
								<li class="dropdown-header">
									<i class="ace-icon fa fa-envelope-o"></i>
									5 Mensajes
								</li>

								<li class="dropdown-content">
									<ul class="dropdown-menu dropdown-navbar">
										<li>
											<a href="#" class="clearfix">
												<img src="images/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Ulises G.:</span>
														Profesor, me urge de su apoyo con el panel ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>Hace unos momentos</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="images/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Heidy:</span>
														Necesito los archivos de css por favor ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>Hace 20 minutos</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="images/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">José Manuel:</span>
														Alguien me puede apoyar corrigiendo el archivo de conexión ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>3:15 pm</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="images/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Miriam:</span>
														No se muestran mis datos en el perfil de usuario ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>12:50 pm</span>
													</span>
												</span>
											</a>
										</li>

										<li>
											<a href="#" class="clearfix">
												<img src="images/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
												<span class="msg-body">
													<span class="msg-title">
														<span class="blue">Alan:</span>
														¿Alguien ya comenzó a trabajar en el proyecto?  ...
													</span>

													<span class="msg-time">
														<i class="ace-icon fa fa-clock-o"></i>
														<span>10:09 am</span>
													</span>
												</span>
											</a>
										</li>
									</ul>
								</li>

								<li class="dropdown-footer">
									<a href="inbox.html">
										Ver todos
										<i class="ace-icon fa fa-arrow-right"></i>
									</a>
								</li>
							</ul>
						</li>

						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="images/logo.png" alt="Dr. Ángel" />
								<span class="user-info">
								<?php
									if( $_SESSION['userName']!="")
									{
									    echo "<small>Bienvenido,</small>".$_SESSION['userName'];
									 
									}
									else{
									    echo "Usuario incorrecto";
									    header('location:index.html');
									}
									
									?>
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

								<li>
									<a id="myBtn" href="#">
										<i class="ace-icon fa fa-user" id="myBtn"></i>
										Perfil
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="../Modelo/cerrar_sesion.php">
										<i class="ace-icon fa fa-power-off"></i>
										Cerrar Sesión
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div><!-- /.CONTENEDOR SUPERIOR AZUL - PANEL DE ADMINISTRACIÓN -->

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.iconos que se usan para las barras -->

<!-- /.Inicia menú de navegación -->
				<ul class="nav nav-list">
					<li class="active">
						<a href="index.html">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Panel </span>
						</a>

						<b class="arrow"></b>
					</li>

						<?php 
						if( $_SESSION['userRol'] == "admin"){
						?>
						<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text">
								Administradores
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a id="altas_admin" href="#">
									<i  id="altas_admin" class="user-icon fa fa-caret-right"></i>
									Altas
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="#">
									<i class="user-icon fa fa-caret-right"></i>
									Bajas y cambios
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
						</li>

						<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text"> Clientes</span>
							<span class="badge badge-primary">2</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Altas
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Bajas y cambios
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
						<?php
						}else{ }
						?>
					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text"> Elemento 3 </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									1
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									2
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									3
								</a>

								<b class="arrow"></b>
							</li>

						</ul>
					</li>

					<li class="">
						<a href="#">
							<i class="menu-icon fa fa-list-alt"></i>
							<span class="menu-text"> Elemento 4 </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#">
							<i class="menu-icon fa fa-calendar"></i>

							<span class="menu-text">
								Elemento 5

								<span class="badge badge-transparent tooltip-error" title="2 Important Events">
									<i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
								</span>
							</span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#">
							<i class="menu-icon fa fa-picture-o"></i>
							<span class="menu-text"> Elemento 6 </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-tag"></i>
							<span class="menu-text"> Elemento 7 </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									1
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file-o"></i>

							<span class="menu-text">
								Elemento 8
								
							</span>

						</a>

						<b class="arrow"></b>
					</li>
				</ul><!-- /.termina menú de navegación izquierdo -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state" id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="#">Inicio</a>
							</li>
							<li class="active">Panel Administrativo</li>
						</ul><!-- /.ruta web -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Buscar..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.barra de busqueda -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<h1>
								Panel Administrativo
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									Detalle de las actividades más recientes
								</small>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>

									<i class="ace-icon fa fa-check green"></i>

									Bienvenido al Panel de Administración
									<strong class="green">
										de nuestro proyecto de TI-II 2017.
										<small>(v1.0)</small>
									</strong>,
	 <a href="https://github.com/angelslv/2_proyectogit">utilizando github</a>.
								</div>

								<div class="row">
									<div class="space-6"></div>

									<div class="col-sm-7 infobox-container">
										<div class="infobox infobox-green">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-comments"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">32</span>
												<div class="infobox-content">comentarios</div>
											</div>

											<div class="stat stat-success">8%</div>
										</div>

										<div class="infobox infobox-blue">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-twitter"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">11</span>
												<div class="infobox-content">nuevos seguidores</div>
											</div>

											<div class="badge badge-success">
												+32%
												<i class="ace-icon fa fa-arrow-up"></i>
											</div>
										</div>

										<div class="infobox infobox-pink">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-shopping-cart"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">8</span>
												<div class="infobox-content">ordenes de compras</div>
											</div>
											<div class="stat stat-important">4%</div>
										</div>

										<div class="infobox infobox-red">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-flask"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">7</span>
												<div class="infobox-content">pruebas </div>
											</div>
										</div>

										<div class="infobox infobox-orange2">
											<div class="infobox-chart">
												<span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">6,251</span>
												<div class="infobox-content">sitios revisados</div>
											</div>

											<div class="badge badge-success">
												7.2%
												<i class="ace-icon fa fa-arrow-up"></i>
											</div>
										</div>

										<div class="infobox infobox-blue2">
											<div class="infobox-progress">
												<div class="easy-pie-chart percentage" data-percent="42" data-size="46">
													<span class="percent">42</span>%
												</div>
											</div>

											<div class="infobox-data">
												<span class="infobox-text">uso de tráfico</span>

												<div class="infobox-content">
													<span class="bigger-110">~</span>
													58GB restante
												</div>
											</div>
										</div>

										<div class="space-6"></div>

										<div class="infobox infobox-green infobox-small infobox-dark">
											<div class="infobox-progress">
												<div class="easy-pie-chart percentage" data-percent="61" data-size="39">
													<span class="percent">61</span>%
												</div>
											</div>

											<div class="infobox-data">
												<div class="infobox-content">Tareas</div>
												<div class="infobox-content">Completas</div>
											</div>
										</div>

										<div class="infobox infobox-blue infobox-small infobox-dark">
											<div class="infobox-chart">
												<span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>
											</div>

											<div class="infobox-data">
												<div class="infobox-content">Ganancias</div>
												<div class="infobox-content">$32,000</div>
											</div>
										</div>

										<div class="infobox infobox-grey infobox-small infobox-dark">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-download"></i>
											</div>

											<div class="infobox-data">
												<div class="infobox-content">Descargas</div>
												<div class="infobox-content">1,205</div>
											</div>
										</div>
									</div>

									<div class="vspace-12-sm"></div>

									<div class="col-sm-5">
										<div class="widget-box">
											<div class="widget-header widget-header-flat widget-header-small">
												<h5 class="widget-title">
													<i class="ace-icon fa fa-signal"></i>
													Gráfica
												</h5>

												<div class="widget-toolbar no-border">
													<div class="inline dropdown-hover">
														<button class="btn btn-minier btn-primary">
															Esta semana
															<i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
														</button>

														<ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
															<li class="active">
																<a href="#" class="blue">
																	<i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
																	Esta semana
																</a>
															</li>

															<li>
																<a href="#">
																	<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
																	Semana pasada
																</a>
															</li>

															<li>
																<a href="#">
																	<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
																	Este mes
																</a>
															</li>

															<li>
																<a href="#">
																	<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
																	Mes pasado
																</a>
															</li>
														</ul>
													</div>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main">
													<div id="piechart-placeholder"></div>

													<div class="hr hr8 hr-double"></div>

													<div class="clearfix">
														<div class="grid3">
															<span class="grey">
																<i class="ace-icon fa fa-facebook-square fa-2x blue"></i>
																&nbsp; Me gusta
															</span>
															<h4 class="bigger pull-right">1,255</h4>
														</div>

														<div class="grid3">
															<span class="grey">
																<i class="ace-icon fa fa-twitter-square fa-2x purple"></i>
																&nbsp; tweets
															</span>
															<h4 class="bigger pull-right">941</h4>
														</div>

														<div class="grid3">
															<span class="grey">
																<i class="ace-icon fa fa-pinterest-square fa-2x red"></i>
																&nbsp; pins
															</span>
															<h4 class="bigger pull-right">1,050</h4>
														</div>
													</div>
												</div><!-- /.widget-principal -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
								</div><!-- /.row -->

								<div class="hr hr32 hr-dotted"></div>

								<div class="row">
									<div class="col-sm-5">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Servicios de la semana
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Nombre
																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Costo
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Estado
																</th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>Formateo Windows 10</td>

																<td>
																	<small>
																		<s class="red">$50.00</s>
																	</small>
																	<b class="green">$39.99</b>
																</td>

																<td class="hidden-480">
																	<span class="label label-info arrowed-right arrowed-in">Con descuento</span>
																</td>
															</tr>

															<tr>
																<td>Instalación de Antivirus</td>

																<td>
																	<b class="blue">$10.00</b>
																</td>

																<td class="hidden-480">
																	<span class="label label-success arrowed-in arrowed-in-right">Costo aprobado</span>
																</td>
															</tr>

															<tr>
																<td>Instalación de Office</td>

																<td>
																	<b class="blue">$12.00</b>
																</td>

																<td class="hidden-480">
																	<span class="label label-danger arrowed">Costo pendiente</span>
																</td>
															</tr>

															<tr>
																<td>Cambios de displays</td>

																<td>
																	<small>
																		<s class="red">$27.00</s>
																	</small>
																	<b class="green">$18.95</b>
																</td>

																<td class="hidden-480">
																	<span class="label arrowed">
																		<s>Sin inventario</s>
																	</span>
																</td>
															</tr>

															<tr>
																<td>Reparación de teclados</td>

																<td>
																	<b class="blue">$12.00</b>
																</td>

																<td class="hidden-480">
																	<span class="label label-warning arrowed arrowed-right">Acabandose</span>
																</td>
															</tr>
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->

									<div class="col-sm-7">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Estado de las ventas
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main padding-4">
													<div id="sales-charts"></div>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
								</div><!-- /.row -->

								<div class="hr hr32 hr-dotted"></div>

								
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Práctica #2. Uso de Git & Github en Proyectos Web Profesionales - Año 2017.</span>
							
						</span>

						&nbsp; &nbsp;
						<span class="action-buttons salto_linea">
							Derechos Reservados: Dr. Ángel Salvador López Vásquez
						</span>
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- script básico usando jquery -->

		<!--[if !IE]> -->
		<script src="js/jquery-2.1.4.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src=js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="js/excanvas.min.js"></script>
		<![endif]-->
		<script src="js/jquery-ui.custom.min.js"></script>
		<script src="js/jquery.ui.touch-punch.min.js"></script>
		<script src="js/jquery.easypiechart.min.js"></script>
		<script src="js/jquery.sparkline.index.min.js"></script>
		<script src="js/jquery.flot.min.js"></script>
		<script src="js/jquery.flot.pie.min.js"></script>
		<script src="js/jquery.flot.resize.min.js"></script>

		<!-- ace scripts -->
		<script src="js/ace-elements.min.js"></script>
		<script src="js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: ace.vars['old_ie'] ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "Redes sociales",  data: 38.7, color: "#68BC31"},
				{ label: "A través de google",  data: 24.5, color: "#2091CF"},
				{ label: "Usando Campañas",  data: 8.2, color: "#AF4E96"},
				{ label: "Trafico directo",  data: 18.6, color: "#DA5430"},
				{ label: "otros",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			  //Ejemplo de jquery con gráficas para el estado de las ventas
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Antivirus", data: d1 },
					{ label: "Formateo", data: d2 },
					{ label: "Servicios", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
		</script>
	</body>
</html>
