		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('storage/usuarios/' . auth()->user()->imagen) }}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{ auth()->user()->name }}
									<span class="user-level">{{ auth()->user()->profile }}</span>
									{{-- <span class="caret"></span> --}}
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								{{-- <ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">Mi Perfil</span>
										</a>
									</li>
									<li>
										<a href="#edit">
											<span class="link-collapse">Editar Perfil</span>
										</a>
									</li>
									<li>
										<a href="#settings">
											<span class="link-collapse">Ajustes</span>
										</a>
									</li>
								</ul> --}}
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						@can('Admin_Views')
						<li class="nav-item active">
							<a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false" style="background-color: #ee761c!important;">
								<i class="fas icon-chart"></i>
								<p>Movimiento Diario</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="dashboard">
								<ul class="nav nav-collapse">
									<li>
										<a href="{{ url('reportentregservices') }}">
											<span class="sub-item">Servicios</span>
										</a>
									</li>
									{{-- <li>
										<a href="{{ url('reportStreaming') }}">
											<span class="sub-item">Streaming</span>
										</a>
									</li> --}}
									<li>
										<a href="{{ url('salemovimientodiario') }}">
											<span class="sub-item">Ventas</span>
										</a>
									</li>
									@can('Reporte_Movimientos_General')
									<li>
										<a href="{{ url('movimientos') }}">
											<i class="fa fas fa-minus"></i>
											Reportes Movimientos</a>
									</li>
									@endcan
									@can('Reporte_Movimientos_General')
									<li>
										<a href="{{ url('resumenmovimientos') }}">
											<i class="fa fas fa-minus"></i>
											Resumen Reportes</a>
									</li>
									@endcan
									@can('Reporte_Movimientos_General')
									<li>
										<a href="{{ url('ingresoegreso') }}">
											<i class="fa fas fa-minus"></i>
											Ingresos/Egresos</a>
									</li>
									@endcan
								</ul>
							</div>
						</li>
						@endcan
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menús y SubMenus</h4>
						</li>
						@can('Ver_TigoMoney_SideBar')
						<li class="nav-item">
							<a data-toggle="collapse" href="#base">
								<img src="assets/img/tigomoney.png" width="29" height="30" alt="navbar brand" class="navbar-brand">
								<p>Tigo Money</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="base">
								@if (empty(session('sesionCaja')))
								<ul class="nav nav-collapse">
									<li>
										<strong style="color: black; ">
											<p> No tiene una caja abierta </p>
											<p> para hacer transacciones </p>
										</strong>
									</li>
									@can('Origen_Index')
										<li>
											<a href="{{ url('origenes') }}">
												<i class="fa fas fa-minus"></i>
											Origen CRUD </a>
										</li>
									@endcan
									@can('Motivo_Index')
										<li>
											<a href="{{ url('motivos') }}">
												<i class="fa fas fa-minus"></i>
											Motivo CRUD </a>
										</li>
									@endcan
									@can('Comision_Index')
										<li>
											<a href="{{ url('comisiones') }}">
												<i class="fa fas fa-minus"></i>
											Comisión CRUD </a>
										</li>
									@endcan
									@can('Origen_Mot_Index')
										<li>
											<a href="{{ url('origen-motivo') }}">
												<i class="fa fas fa-minus"></i>
											Origen motivo </a>
										</li>
									@endcan
									@can('Origen_Mot_Com_Index')
										<li>
											<a href="{{ url('origen-motivo-comision') }}">
												<i class="fa fas fa-minus"></i>
											Origen motivo comisiones</a>
										</li>
									@endcan
									@can('Jornada_Tigo_Index')
										<li>
											<a href="{{ url('ReporteJornalTM') }}">
												<i class="fa fas fa-minus"></i>
											Reporte Jornada T.M.</a>
										</li>
									@endcan
									@can('Arqueos_Tigo_Index')
										<li>
											<a href="{{ url('arqueostigo') }}" style="width="17" height="17""> 
												<i class="fa fas fa-minus"></i>
											Arqueos Tigo</a>
										</li>
									@endcan
									
								

									<li>
										<a href="{{ url('movimientos') }}">
											<i class="fa fas fa-minus"></i>
											Reportes Movimientos</a>
									</li>
								</ul>
								@else
								<ul class="nav nav-collapse">
									@can('Tigo_Money_Index')
									<li>
										<a href="{{ url('tigomoney') }}">
											<i class="fa fas fa-minus"></i>
											Nueva Transacción </a>
									</li>
									@endcan
									  @can('Origen_Index')
									  <li>
										  <a href="{{ url('origenes') }}">
											<i class="fa fas fa-minus"></i>
											Origen CRUD </a>
									  </li>
								  	@endcan
								  @can('Motivo_Index')
									  <li>
										  <a href="{{ url('motivos') }}">
											<i class="fa fas fa-minus"></i>
											Motivo CRUD </a>
									  </li>
								  @endcan
								  @can('Comision_Index')
									  <li>
										  <a href="{{ url('comisiones') }}">
											<i class="fa fas fa-minus"></i>
											Comisión CRUD </a>
									  </li>
								  @endcan
								  @can('Origen_Mot_Index')
									  <li>
										  <a href="{{ url('origen-motivo') }}">
											<i class="fa fas fa-minus"></i>
											Origen motivo </a>
									  </li>
								  @endcan
								  @can('Origen_Mot_Com_Index')
									  <li>
										  <a href="{{ url('origen-motivo-comision') }}">
											<i class="fa fas fa-minus"></i>
											Origen motivo comisiones</a>
									  </li>
								  @endcan
								  @can('Jornada_Tigo_Index')
									  <li>
										  <a href="{{ url('ReporteJornalTM') }}">
											<i class="fa fas fa-minus"></i>
											  Reporte Jornada T.M.</a>
									  </li>
								  @endcan
								  @can('Arqueos_Tigo_Index')
									  <li>
										  <a href="{{ url('arqueostigo') }}">
											<i class="fa fas fa-minus"></i>
											  Arqueos Tigo</a>
									  </li>
								  @endcan
			  
								  @can('Reportes_Tigo_Index')
									  <li>
										  <a href="{{ url('reportestigo') }}">
											<i class="fa fas fa-minus"></i>
											  Reportes Tigo</a>
									  </li>
								  @endcan
								  @can('Reportes_Tigo_Index')
								  <li>
									  <a href="{{ url('movimientos') }}">
										<i class="fa fas fa-minus"></i>
										  Reportes Movimientos</a>
								  </li>
								  @endcan
								</ul>
								@endif
							</div>
						</li>
						@endcan
						{{-- <li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<img src="assets/img/disney.png" width="30" height="40" alt="navbar brand" class="navbar-brand">
								<p>Streaming</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								@if (empty(session('sesionCaja')))
								<ul class="nav nav-collapse">
									<li>
										<strong style="color: black; ">
											<p> No tiene una caja abierta </p>
											<p> para vender planes </p>
										</strong>
									</li>
									@can('Cuentas_Index')
										<li>
											<a href="{{ url('cuentas') }}">
												<i class="fa fas fa-minus"></i>
												Cuentas </a>
										</li>
									@endcan
									@can('Perfiles_Index')
										<li>
											<a href="{{ url('perfiles') }}">
												<i class="fa fas fa-minus"></i>
												Perfiles </a>
										</li>
									@endcan
									@can('Plataforma_Index')
										<li>
											<a href="{{ url('plataformas') }}">
												<i class="fa fas fa-minus"></i>
												Plataformas </a>
										</li>
									@endcan
									@can('Proveedor_Index')
										<li>
											<a href="{{ url('strproveedores') }}">
												<i class="fa fas fa-minus"></i>
												Proveedores </a>
										</li>
									@endcan
									@can('Correos_Index')
										<li>
											<a href="{{ url('emails') }}">
												<i class="fa fas fa-minus"></i>
												Correos </a>
										</li>
									@endcan
									@can('Reportes_Streaming_Index')
										<li>
											<a href="{{ url('reportStreaming') }}">
												<i class="fa fas fa-minus"></i>
												Reportes Streaming </a>
										</li>
									@endcan
								</ul>
								@else
								<ul class="nav nav-collapse">
									@can('Planes_Index')
										<li>
											<a href="{{ url('planes') }}">
												<i class="fa fas fa-minus"></i>
												Nuevo Plan </a>
										</li>
									@endcan
									@can('Cuentas_Index')
										<li>
											<a href="{{ url('cuentas') }}">
												<i class="fa fas fa-minus"></i>
												Cuentas </a>
										</li>
									@endcan
									@can('Perfiles_Index')
										<li>
											<a href="{{ url('perfiles') }}">
												<i class="fa fas fa-minus"></i>
												Perfiles </a>
										</li>
									@endcan
									@can('Plataforma_Index')
										<li>
											<a href="{{ url('plataformas') }}">
												<i class="fa fas fa-minus"></i>
												Plataformas </a>
										</li>
									@endcan
									@can('Proveedor_Index')
										<li>
											<a href="{{ url('strproveedores') }}">
												<i class="fa fas fa-minus"></i>
												Proveedores </a>
										</li>
									@endcan
									@can('Correos_Index')
										<li>
											<a href="{{ url('emails') }}">
												<i class="fa fas fa-minus"></i>
												Correos </a>
										</li>
									@endcan
									@can('Arqueos_Streaming_Index')
										<li>
											<a href="{{ url('arqueosStreaming') }}">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
													fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
													stroke-linejoin="round" class="feather feather-dollar-sign">
													<line x1="12" y1="1" x2="12" y2="23"></line>
													<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
												</svg>
												Arqueos Streaming </a>
										</li>
									@endcan
									@can('Reportes_Streaming_Index')
										<li>
											<a href="{{ url('reportStreaming') }}">
												<i class="fa fas fa-minus"></i>
												Reportes Streaming </a>
										</li>
									@endcan
									<li>
										<a href="{{ url('reportGananciaStreaming') }}">
											<i class="fa fas fa-minus"></i>
											Reportes Ganancias Streaming </a>
									</li>
								</ul>
								@endif
							</div>
						</li> --}}
						@can('Service_Index')
						<li class="nav-item">
							<a data-toggle="collapse" href="#forms">
								<img src="assets/img/serviciotecnico.png" width="30" height="40" alt="navbar brand" class="navbar-brand">
								<p>Servicios</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="forms">
								<ul class="nav nav-collapse">
								@can('Cat_Prod_Service_Index')
								<li>
									<a href="{{ url('catprodservice') }}">
										<i class="fa fas fa-minus"></i>
										Categoria Equipo </a>
								</li>
								@endcan
								@can('SubCat_Prod_Service_Index')
									<li>
										<a href="{{ url('subcatprodservice') }}">
											<i class="fa fas fa-minus"></i>
											Sub Categ. Equipo </a>
									</li>
								@endcan
								@can('Type_Work_Index')
									<li>
										<a href="{{ url('typework') }}">
											<i class="fa fas fa-minus"></i>
											Tipo de Trabajo </a>
									</li>
								@endcan
								@can('Orden_Servicio_Index')
									<li>
										<a href="{{ url('orderservice') }}">
											<i class="fa fas fa-minus"></i>
											Orden de Servicio </a>
									</li>
								@endcan
								@can('Reporte_Servicios_Index')
									<li>
										<a href="{{ url('reporteservices') }}">
											<i class="fa fas fa-minus"></i>
											Reporte de Servicios </a>
									</li>
								@endcan
								@can('Boton_Entregar_Servicio')
									<li>
										<a href="{{ url('reportentregservices') }}">
											<i class="fa fas fa-minus"></i>
											Repor. Servi. Entregados </a>
									</li>
								@endcan
								</ul>
							</div>
						</li>
						@endcan
						@can('Admin_Views')
						<li class="nav-item">
							<a data-toggle="collapse" href="#tables">
								<img src="assets/img/administracion.png" width="25" height="35" alt="navbar brand" class="navbar-brand">
								<p>Administración</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="tables">
								<ul class="nav nav-collapse">
									@can('Roles_Index')
									<li>
										<a href="{{ url('roles') }}">
											<i class="fa fas fa-minus"></i>
											Roles </a>
									</li>
									@endcan
									@can('Permission_Index')
										<li>
											<a href="{{ url('permisos') }}">
												<i class="fa fas fa-minus"></i>
												Permisos </a>
										</li>
									@endcan
									@can('Asignar_Index')
										<li>
											<a href="{{ url('asignar') }}">
												<i class="fa fas fa-minus"></i>
												Asignar permisos </a>
										</li>
									@endcan
									@can('Usuarios_Index')
										<li>
											<a href="{{ url('users') }}">
												<i class="fa fas fa-minus"></i>
												Usuarios </a>
										</li>
									@endcan
									@can('Cliente_Index')
										<li>
											<a href="{{ url('clientes') }}">
												<i class="fa fas fa-minus"></i>
												Clientes </a>
										</li>
									@endcan
									@can('Procedencia_Index')
										<li>
											<a href="{{ url('procedenciaCli') }}">
												<i class="fa fas fa-minus"></i>
												Procedencia Clientes </a>
										</li>
									@endcan
									@can('Empresa_Index')
										<li>
											<a href="{{ url('companies') }}">
												<i class="fa fas fa-minus"></i>
												Empresa </a>
										</li>
									@endcan
									@can('Sucursal_Index')
										<li>
											<a href="{{ url('sucursales') }}">
												<i class="fa fas fa-minus"></i>
												Sucursales </a>
										</li>
									@endcan
									@can('Caja_Index')
										<li>
											<a href="{{ url('cajas') }}">
												<i class="fa fas fa-minus"></i>
												Cajas </a>
										</li>
									@endcan
									@can('Cartera_Index')
										<li>
											<a href="{{ url('carteras') }}">
												<i class="fa fas fa-minus"></i>
												Cartera </a>
										</li>
										<li>
											<a href="{{ url('carteramovcategoria') }}">
												<i class="fa fas fa-minus"></i>
												Cartera Mov Categoria </a>
										</li>

									@endcan
									@can('Corte_Caja_Index')
										<li>
											<a href="{{ url('cortecajas') }}">
												<i class="fa fas fa-minus"></i>
												Corte caja </a>
										</li>
									@endcan
								</ul>
							</div>
						</li>
						@endcan

						
						
						
						@can('Almacen_Index')
						<li class="nav-item">
							<a data-toggle="collapse" href="#charts">
								<img src="assets/img/inventarios.png" width="25" height="35" alt="navbar brand" class="navbar-brand">
								<p>Inventarios</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="charts">
								<ul class="nav nav-collapse">
									<li>
										<a href="{{url('proveedores')}}">
											<i class="fa fas fa-minus"></i>
											Proveedores </a>
									</li>
									<li>
										<a href="{{ url('categories') }}">
											<i class="fa fas fa-minus"></i>
											Categorias </a>
									</li>
									<li>
										<a href="{{ url('products') }}">
											<i class="fa fas fa-minus"></i>
											Productos </a>
									</li>
									{{-- <li>
										<a href="{{url('transacciones')}}">
											<i class="fa fas fa-minus"></i>
											Devolucion en Compras </a>
									</li> --}}
									<li>
										<a href="{{url('compras')}}">
											<i class="fa fas fa-minus"></i>
											Compras </a>
									</li>
									<li>
										<a href="{{url('destino_prod')}}">
											<i class="fa fas fa-minus"></i>
											Almacen Producto </a>
									</li>
									<li>
										<a href="{{url('operacionesinv')}}">
											<i class="fa fas fa-minus"></i>
											Entrada/Salida de Productos </a>
									</li>
									<li>
										<a href="{{url('all_transferencias')}}">
											<i class="fa fas fa-minus"></i>
											Transferencia de Productos </a>
									</li>
								</ul>
							</div>
						</li>

						<li class="nav-item">
							<a data-toggle="collapse" href="#charts2">
								<img src="assets/img/parametros.png" width="25" height="35" alt="navbar brand" class="navbar-brand">
								<p>Parámetros</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="charts2">
								<ul class="nav nav-collapse">
									<li>
										<a href="{{url('destino')}}">
											<i class="fa fas fa-minus"></i>
											Locacion/Estancia </a>
									</li>
									<li>
										<a href="{{url('locations')}}">
											<i class="fa fas fa-minus"></i>
											Mobiliario </a>
									</li>
									<li>
										<a href="{{ url('unidades') }}">
											<i class="fa fas fa-minus"></i>
											Unidades </a>
									</li>
									<li>
										<a href="{{ url('marcas') }}">
											<i class="fa fas fa-minus"></i>
											Marcas </a>
									</li>
								</ul>
							</div>
						</li>
						@endcan





						{{-- <li class="nav-item">
							<a href="widgets.html">
								<i class="fas fa-desktop"></i>
								<p>Widgets</p>
								<span class="badge badge-success">4</span>
							</a>
						</li> --}}




						<li class="nav-item">
							<a data-toggle="collapse" href="#submenu">
								<img src="assets/img/ventas.png" width="25" height="35" alt="navbar brand" class="navbar-brand">
								<p>Ventas</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="submenu">
								<ul class="nav nav-collapse">

									<li>
										<a href="{{ url('pos') }}">
											<i class="fa fas fa-minus"></i>
											Nueva Venta </a>
									</li>
									<li>
										<a href="{{ url('salelist') }}">
											<i class="fa fas fa-minus"></i>
											Lista de Ventas </a>
									</li>
									{{-- <li>
										<a href="{{ url('estadisticas') }}">
											<i class="fa fas fa-minus"></i>
											Estadísticas </a>
									</li> --}}
									@can('VentasMovDia_Index')
									<li>
										<a href="{{ url('coins') }}">
											<i class="fa fas fa-minus"></i>
											Denominaciones </a>
									</li>
									<li>
										<a href="{{ url('devolucionventa') }}">
											<i class="fa fas fa-minus"></i>
											Devolución Ventas </a>
									</li>
									<li>
										<a href="{{ url('salemovimientodiario') }}">
											<i class="fa fas fa-minus"></i>
											Movimiento Diario Ventas</a>
									</li>
									<li>
										<a href="{{ url('ventasreportecantidad') }}">
											<i class="fa fas fa-minus"></i>
											Reporte Ventas Usuarios</a>
									</li>
									@endcan


									{{-- <li>
										<a data-toggle="collapse" href="#subnav1">
											<span class="sub-item">Level 1</span>
											<span class="caret"></span>
										</a>
										<div class="collapse" id="subnav1">
											<ul class="nav nav-collapse subnav">
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li>
										<a data-toggle="collapse" href="#subnav2">
											<span class="sub-item">Level 1</span>
											<span class="caret"></span>
										</a>
										<div class="collapse" id="subnav2">
											<ul class="nav nav-collapse subnav">
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li>
										<a href="#">
											<span class="sub-item">Level 1</span>
										</a>
									</li> --}}
								</ul>
							</div>
						</li>
						<li class="mx-4 mt-2">
								<a style="background-color: #ee761c!important;" class="btn btn-primary btn-block" href="{{ route('logout') }}"
									onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
									<span class="btn-label mr-2">
										<i class="fa icon-logout"></i> 
									   </span>Cerrar Sesión
								</a>
								<form action="{{ route('logout') }}" method="POST" id="logout-form">
								@csrf
								</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->