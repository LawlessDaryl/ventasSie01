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
								<svg width="25" height="35"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><style>.cls-1{fill:#393933;}</style></defs><g id="Capa_6" data-name="Capa 6"><g id="Menu"><g id="Boton_servicios" data-name="Boton servicios"><g id="levls"><rect class="cls-1" x="10" y="68.63" width="52.1" height="126.73"/><rect class="cls-1" x="73.75" y="100.12" width="52.1" height="95.24"/><rect class="cls-1" x="137.9" y="4.64" width="52.1" height="190.72"/></g></g></g></g></svg>
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
								@can('Reporte_Servicios_Index')
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
								{{-- <img src="assets/img/administracion.png" width="25" height="35" alt="navbar brand" class="navbar-brand"> --}}
								<svg width="25" height="35" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><style>.cls-1{fill:#393933;}</style>
								</defs><g id="Capa_6" data-name="Capa 6"><g id="Menu"><g id="Boton_Administración" 
									data-name="Boton Administración"><path class="cls-1" 
									d="M87.91,196.8Q87,188.46,86,180.11c-.26-2.26-.44-4.52-.78-6.76a1.92,1.92,0,0,0-1-1.24c-5.55-2.18-11.12-4.28-17.09-6.56l-9,7.28-9.25,7.46L31.6,163c.25-.32.73-1,1.23-
1.58,4.32-5.34,8.61-10.7,13-16a2.08,2.08,0,0,0,.23-2.62q-3.19-7.23-6.06-14.6c-.43-1.08-.8-1.6-2-1.72-7.21-.69-14.41-1.47-21.6-2.29-.48-.05-1.26-.7-1.27-1.09C15,119.42,15,115.77,15,112H71.33c.35,9,3.82,16.6,10.93,22.3a28.6,28.6,0,0,0,38-2.26,28.47,28.47,0,0,0,8.36-20.1H185c0,3.84,0,7.6-.05,11.35,0,.32-.8.86-1.27.91-7.13.81-14.27,1.6-21.41,2.26-1.4.13-1.8.71-2.27,1.92-1.88,4.86-3.9,9.66-6,14.42a2.07,2.07,0,0,0,.24,2.62c4.32,5.25,8.58,10.56,12.85,15.85.51.63,1,1.27,1.43,1.8l-17.39,17.24-18.23-14.72c-6,2.28-11.55,4.37-17.08,6.57a2.24,2.24,0,0,0-1.06,1.61c-.81,7.07-1.54,14.14-2.3,21.22-.06.62-.22,1.23-.33,1.85Z"/><path class="cls-1" d="M142.74,100.36H57.32a4.83,4.83,0,0,1-.14-.8c0-9.13-.14-18.26,0-27.39a19.32,19.32,0,0,1,19.33-19q23.41-.18,46.85,0A19.34,19.34,0,0,1,142.8,72.31c.18,9,0,18,0,27A10,10,0,0,1,142.74,100.36Z"/><path class="cls-1" d="M100.05,47.06a21.93,21.93,0,1,1,21.89-21.87A22,22,0,0,1,100.05,47.06Z"/><path class="cls-1" d="M45.82,100.34H15.11c0-.67-.09-1.22-.09-1.78,0-7.31,0-14.62,0-21.93C15.07,69.15,18.1,63.33,25,60a15.66,15.66,0,0,1,6.12-1.64c6-.21,12.05-.07,18.14-.07A39.36,39.36,0,0,0,47.13,64a55.76,55.76,0,0,0-1.25,9.69c-.17,8.12-.06,16.25-.06,24.38Z"/><path class="cls-1" d="M184.75,100.34H154.2V98q0-13.12-.07-26.27a28.56,28.56,0,0,0-2.9-12.2c-.19-.39-.33-.79-.57-1.38.7,0,1.24-.09,1.77-.08,5.79.09,11.6-.06,17.37.34,7.66.54,14.59,7.48,14.87,15.15C185,82.4,184.75,91.28,184.75,100.34Z"/><path class="cls-1" d="M53.36,13.37c14.08,0,23.8,14.64,18.15,27.38a3.19,3.19,0,0,1-2.39,2.07,30.67,30.67,0,0,0-15,8.71,3.65,3.65,0,0,1-2.58.95A19.59,19.59,0,0,1,42.36,16.8,19.45,19.45,0,0,1,53.36,13.37Z"/><path class="cls-1" d="M146.53,13.37c10.28,0,19.24,8.37,19.64,18.4a19.66,19.66,0,0,1-18,20.74,3.2,3.2,0,0,1-2.24-.88,32.3,32.3,0,0,0-15.28-9,3.49,3.49,0,0,1-2-1.65C122.67,28.43,132.39,13.39,146.53,13.37Z"/></g></g></g></svg>
								
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
								<svg width="25" height="35"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><defs><style>.cls-1{fill:#393933;}</style></defs><g id="Capa_6" data-name="Capa 6"><g id="Menu"><g id="Boton_Inventarios" data-name="Boton Inventarios"><path class="cls-1" d="M98.52,6.12h2.94l2.4,1.23q40.79,20.25,81.58,40.46c3.24,1.59,4.56,3.75,4.55,7.3q-.11,44.77,0,89.54c0,3.74-1.48,6-4.78,7.61Q144,172.54,103,193A7.18,7.18,0,0,1,96,193q-40.89-20.44-81.82-40.8A6.91,6.91,0,0,1,10,145.31q.08-45.32,0-90.64a6.78,6.78,0,0,1,4.23-6.78q16-7.8,31.83-15.83a2.71,2.71,0,0,1,2.84.07q41.43,21.42,82.89,42.76a2.82,2.82,0,0,1,1.8,2.93c-.06,13.82,0,27.64,0,41.47,0,3.86,1,4.46,4.51,2.64,4.61-2.41,9.17-4.89,13.83-7.17a4.41,4.41,0,0,0,2.8-4.56q-.15-21.11,0-42.2a4.42,4.42,0,0,0-2.82-4.63Q111.32,42.69,70.83,21.86c-.56-.28-1.1-.63-1.93-1.1Z"/></g></g></g></svg>
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



						@can('Sales_Index')
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
						@endcan
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