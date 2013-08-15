<!DOCTYPE html>
<html>
<head>
	<title>Luminarias</title>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/mapa.css" />

	<script src="js/jquery.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script>
		var // Funciones y variable globales

		lumiJSON = 'json/lumi.php',
		query = '';
		pos = {
			lat: 7.98383,
			lng: -75.42071
		},
		edit_pos = 0;

		// Google Maps
		mapa = function () {
			var center = new google.maps.LatLng( pos.lat, pos.lng ),
				myOptions = {
					zoom: 15,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				},
				map = new google.maps.Map( document.getElementById('mapa'), myOptions);
			map.setCenter(center);
			var marker = new google.maps.Marker({
				position: center,
				map: map
			});

			var
				circle_fiusha = new google.maps.MarkerImage(
					'img/circle_fiusha.png',
					new google.maps.Size(20, 20),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 20)
				),
				circle_blue = new google.maps.MarkerImage(
					'img/circle_blue.png',
					new google.maps.Size(20, 20),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 20)
				),
				circle_green = new google.maps.MarkerImage(
					'img/circle_green.png',
					new google.maps.Size(20, 20),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 20)
				),
				circle_yellow = new google.maps.MarkerImage(
					'img/circle_yellow.png',
					new google.maps.Size(20, 20),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 20)
				),
				circle_white = new google.maps.MarkerImage(
					'img/circle_white.png',
					new google.maps.Size(20, 20),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 20)
				),
				circle_black = new google.maps.MarkerImage(
					'img/circle_black.png',
					new google.maps.Size(20, 20),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 20)
				),
				triangle_fiusha = new google.maps.MarkerImage(
					'img/triangle_fiusha.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				triangle_blue = new google.maps.MarkerImage(
					'img/triangle_blue.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				triangle_green = new google.maps.MarkerImage(
					'img/triangle_green.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				triangle_yellow = new google.maps.MarkerImage(
					'img/triangle_yellow.png',
					new google.maps.Size(32, 32),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 32)
				),
				square_fiusha = new google.maps.MarkerImage(
					'img/square_fiusha.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				square_blue = new google.maps.MarkerImage(
					'img/square_blue.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				square_green = new google.maps.MarkerImage(
					'img/square_green.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				square_yellow = new google.maps.MarkerImage(
					'img/square_yellow.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				square_red = new google.maps.MarkerImage(
					'img/square_red.png',
					new google.maps.Size(32, 32),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 32)
				),
				star_fiusha = new google.maps.MarkerImage(
					'img/star_fiusha.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				star_blue = new google.maps.MarkerImage(
					'img/star_blue.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				star_green = new google.maps.MarkerImage(
					'img/star_green.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				),
				star_yellow = new google.maps.MarkerImage(
					'img/star_yellow.png',
					new google.maps.Size(24, 24),
					new google.maps.Point(0, 0),
					new google.maps.Point(2, 24)
				);

			jQuery.getJSON( lumiJSON + query, function( res ){
				lum = res.coor;
				$('#lumi_total').text( res.details.total );
				$('#lumi_showing').text( res.details.showing );
				$('#lumi_percent').text( res.details.percent + '%' );
				$('#sumpo').text( res.details.sum );
				for ( c = 0; c < lum.length; c++ ){

					var icon;
					switch( lum[c].key ){
						case 'circle_fiusha': icon = circle_fiusha; break;
						case 'circle_blue': icon = circle_blue; break;
						case 'circle_green': icon = circle_green; break;
						case 'circle_yellow': icon = circle_yellow; break;
						case 'circle_white': icon = circle_white; break;
						case 'circle_black': icon = circle_black; break;
						case 'triangle_fiusha': icon = triangle_fiusha; break;
						case 'triangle_blue': icon = triangle_blue; break;
						case 'triangle_green': icon = triangle_green; break;
						case 'triangle_yellow': icon = triangle_yellow; break;
						case 'square_fiusha': icon = square_fiusha; break;
						case 'square_blue': icon = square_blue; break;
						case 'square_green': icon = square_green; break;
						case 'square_yellow': icon = square_yellow; break;
						case 'square_red': icon = square_red; break;
						case 'star_fiusha': icon = star_fiusha; break;
						case 'star_blue': icon = star_blue; break;
						case 'star_green': icon = star_green; break;
						case 'star_yellow': icon = star_yellow; break;
						default: icon = circle_fiusha; break;
					}

					var bombipos = new google.maps.LatLng( lum[c].lat , lum[c].lng ),
					bombi = new google.maps.Marker({
						position: bombipos,
						map: map,
						icon: icon
					});

					if ( edit_pos == 1 ){
						bombi.dragable = true;
						google.maps.event.addListener(bombi,'dragend',function() {
							pos = this.getPosition();
							$.post("php/updatelumi.php",
								{
									"id" : lum[c].id,
									"lat" : pos.lat(),
									"long" : pos.lng()*-1
								},function(res){
								}
							);
						});
					}
				}
			});
		};

		// Tiempo de ejecucion
		jQuery(function(){
			mapa();

			$('#edit_pos').click(function(e){
				e.preventDefault();
				if ( edit_pos == 1 ){
					$('#editmarks').hide();
					edit_pos = 0;
				}else{
					$('#editmarks').show();
					edit_pos = 1;
				}
				mapa();
			});

			var filters = [];

			var ftr_serial = $('#ftr_serial'), txt_srial = $('[name="serial"]'),
				ftr_ser_sts = 0, ftr_ser_txt = 'Buscar el serial <em>{s}</em>';
			ftr_serial.click(function(e){
				e.preventDefault();
				if ( ftr_ser_sts == 1 ){
					txt_srial.attr("disabled", "disabled");
					filters.splice( filters.indexOf('serial'), 1);
					ftr_ser_sts = 0;
					ftr_serial.removeClass('checked');
					ftr_serial.addClass('unchecked');
				}else{
					txt_srial.removeAttr("disabled");
					filters.push('serial');
					ftr_ser_sts = 1;
					ftr_serial.removeClass('unchecked');
					ftr_serial.addClass('checked');
				}
			});

			var ftr_barrios = $('#ftr_barrios'), txt_barrios = $('[name="barrios"]'),
				ftr_bar_sts = 0, ftr_bar_txt = 'Buscar en <em>{s}</em>';
			ftr_barrios.click(function(e){
				e.preventDefault();
				if ( ftr_bar_sts == 1 ){
					txt_barrios.attr("disabled", "disabled");
					filters.splice( filters.indexOf('barrios'), 1);
					ftr_bar_sts = 0;
					ftr_barrios.removeClass('checked');
					ftr_barrios.addClass('unchecked');
				}else{
					txt_barrios.removeAttr("disabled");
					filters.push('barrios');
					ftr_bar_sts = 1;
					ftr_barrios.removeClass('unchecked');
					ftr_barrios.addClass('checked');
				}
			});

			var ftr_mes = $('#ftr_mes'), txt_mes = $('[name="mes"]'),
				ftr_mes_sts = 0, ftr_mes_txt = 'Buscar en el mes de <em>{s}</em>';
			ftr_mes.click(function(e){
				e.preventDefault();
				if ( ftr_mes_sts == 1 ){
					txt_mes.attr("disabled", "disabled");
					filters.splice( filters.indexOf('mes'), 1);
					ftr_mes_sts = 0;
					ftr_mes.removeClass('checked');
					ftr_mes.addClass('unchecked');
				}else{
					txt_mes.removeAttr("disabled");
					filters.push('mes');
					ftr_mes_sts = 1;
					ftr_mes.removeClass('unchecked');
					ftr_mes.addClass('checked');
				}
			});

			var ftr_anio = $('#ftr_anio'), txt_anio = $('[name="anio"]'),
				ftr_anio_sts = 0, ftr_anio_txt = 'Buscar en el año <em>{s}</em>';
			ftr_anio.click(function(e){
				e.preventDefault();
				if ( ftr_anio_sts == 1 ){
					txt_anio.attr("disabled", "disabled");
					filters.splice( filters.indexOf('anio'), 1);
					ftr_anio_sts = 0;
					ftr_anio.removeClass('checked');
					ftr_anio.addClass('unchecked');
				}else{
					txt_anio.removeAttr("disabled");
					filters.push('anio');
					ftr_anio_sts = 1;
					ftr_anio.removeClass('unchecked');
					ftr_anio.addClass('checked');
				}
			});

			var ftr_estado = $('#ftr_estado'), txt_estado = $('[name="estado"]'),
				ftr_edo_sts = 0, ftr_edo_txt = 'Buscar luminarias <em>{s}</em>';
			ftr_estado.click(function(e){
				e.preventDefault();
				if ( ftr_edo_sts == 1 ){
					txt_estado.attr("disabled", "disabled");
					filters.splice( filters.indexOf('estado'), 1);
					ftr_edo_sts = 0;
					ftr_estado.removeClass('checked');
					ftr_estado.addClass('unchecked');
				}else{
					txt_estado.removeAttr("disabled");
					filters.push('estado');
					ftr_edo_sts = 1;
					ftr_estado.removeClass('unchecked');
					ftr_estado.addClass('checked');
				}
			});

			var ftr_potencia = $('#ftr_potencia'), txt_potencia = $('[name="potencia"]'),
				ftr_po_sts = 0, ftr_po_txt = 'Buscar luminarias de <em>{s} watts</em>';
			ftr_potencia.click(function(e){
				e.preventDefault();
				if ( ftr_po_sts == 1 ){
					txt_potencia.attr("disabled", "disabled");
					filters.splice( filters.indexOf('potencia'), 1);
					ftr_po_sts = 0;
					ftr_potencia.removeClass('checked');
					ftr_potencia.addClass('unchecked');
				}else{
					txt_potencia.removeAttr("disabled");
					filters.push('potencia');
					ftr_po_sts = 1;
					ftr_potencia.removeClass('unchecked');
					ftr_potencia.addClass('checked');
				}
			});

			var ftr_reparadas = $('#ftr_reparadas'),
				ftr_rep_sts = 0, ftr_rep_txt = 'Buscar luminarias reparadas';
			ftr_reparadas.click(function(e){
				e.preventDefault();
				if ( ftr_rep_sts == 1 ){
					filters.splice( filters.indexOf('reparadas'), 1);
					ftr_rep_sts = 0;
					ftr_reparadas.removeClass('checked');
					ftr_reparadas.addClass('unchecked');
				}else{
					filters.push('reparadas');
					ftr_rep_sts = 1;
					ftr_reparadas.removeClass('unchecked');
					ftr_reparadas.addClass('checked');
				}
			});

			var ftr_nuevas = $('#ftr_nuevas'),
				ftr_new_sts = 0, ftr_new_txt = 'Buscar luminarias nuevas';
			ftr_nuevas.click(function(e){
				e.preventDefault();
				if ( ftr_new_sts == 1 ){
					filters.splice( filters.indexOf('nuevas'), 1);
					ftr_new_sts = 0;
					ftr_nuevas.removeClass('checked');
					ftr_nuevas.addClass('unchecked');
				}else{
					filters.push('nuevas');
					ftr_new_sts = 1;
					ftr_nuevas.removeClass('unchecked');
					ftr_nuevas.addClass('checked');
				}
			});

			var btn_filtrar = $('#filtrar'), list_filter = $('#list_filter');
			btn_filtrar.click(function(e){
				e.preventDefault();
				$('#fltr_all').remove();
				var ftrc = filters.length, _query = '';
				if ( ftrc > 0 ){
					for ( i = 0; i < ftrc; i++ ){
						var li = $('<li></li>'), litxt, lival;
						li.addClass('filter');

						switch( filters[i] ){
							case 'serial':
								$('#li_serial').remove();
								li.attr('id','li_serial');
								litxt = ftr_ser_txt;
								lival = txt_srial.val();
							break;
							case 'barrios':
								$('#li_barrios').remove();
								li.attr('id','li_barrios');
								litxt = ftr_bar_txt;
								lival = txt_barrios.val();
							break;
							case 'mes':
								$('#li_mes').remove();
								li.attr('id','li_mes');
								litxt = ftr_mes_txt;
								lival = txt_mes.val();
							break;
							case 'anio':
								$('#li_anio').remove();
								li.attr('id','li_anio');
								litxt = ftr_anio_txt;
								lival = txt_anio.val();
							break;
							case 'estado':
								$('#li_estado').remove();
								li.attr('id','li_estado');
								litxt = ftr_edo_txt;
								lival = txt_estado.val();
							break;
							case 'potencia':
								$('#li_potencia').remove();
								li.attr('id','li_potencia');
								litxt = ftr_po_txt;
								lival = txt_potencia.val();
							break;
							case 'reparadas':
								$('#li_reparadas').remove();
								li.attr('id','li_reparadas');
								litxt = ftr_rep_txt;
								lival = 'true';
							break;
							case 'nuevas':
								$('#li_nuevas').remove();
								li.attr('id','li_nuevas');
								litxt = ftr_new_txt;
								lival = 'true';
							break;
						}

						_query += '&' + filters[i] + '=' + lival;
						litxt = litxt.replace('{s}', lival);
						li.html( litxt );
						list_filter.append(li);
					}
				}else{
					_query = '';
					list_filter.html('<li class="title">Filtros aplicados</li><li id="fltr_all" class="filter">Buscar todas las luminarias</li>');
				}
				query = '?q=void' + _query;
				mapa();
			});

			$('#fullscreen').click(function(e){
				e.preventDefault();
				$('#mapa').css({
					'position': 'absolute',
					'top': '-20px', 'left': '0', 'bottom': '-20px', 'right': '0',
					'width': 'auto', 'height': 'auto',
					'z-index': '9999'
				});
				$('#normalscreen').show();
				mapa();
			});
			$('#normalscreen').click(function(e){
				e.preventDefault();
				$('#mapa').css({
					'position': 'relative',
					'top': '0', 'left': '0', 'bottom': '0', 'right': '0',
					'width': '560px', 'height': '400px'
				});
				$('#normalscreen').hide();
				mapa();
			});
		});
	</script>


</head>
<body>
	<div id="content">

		<aside>
			<div class="sec">
				<h1>Panel de control</h1>
			</div>
			<div class="sec">
				<h2>Edición</h2>
				<a id="edit_pos" class="button" href="#">Editar coordenadas</a>
			</div>
			<div class="sec">
				<h2>Filtrar</h2>
				<div class="fieldset">
					<div><a id="ftr_serial" class="button inline unchecked" href="#">Serial</a></div>
					<input type="text" name="serial" disabled />
				</div>
				<div class="fieldset">
					<div><a id="ftr_barrios" class="button inline unchecked" href="#">Barrios</a></div>
					<input type="text" name="barrios" disabled />
				</div>
				<div class="fieldset">
					<div><a id="ftr_mes" class="button inline unchecked" href="#">Mes</a></div>
					<input type="text" name="mes" disabled />
				</div>
				<div class="fieldset">
					<div><a id="ftr_anio" class="button inline unchecked" href="#">Año</a></div>
					<input type="text" name="anio" disabled />
				</div>
				<div class="fieldset">
					<div><a id="ftr_estado" class="button inline unchecked" href="#">Estado</a></div>
					<input type="text" name="estado" disabled />
				</div>
				<div class="fieldset">
					<div><a id="ftr_potencia" class="button inline unchecked" href="#">Potencia</a></div>
					<input type="text" name="potencia" disabled />
				</div>
				<div class="fieldset">
					<a id="ftr_reparadas" class="button inline unchecked" href="#">Reparadas</a>
					<a id="ftr_nuevas" class="button inline unchecked" href="#">Nuevas</a>
				</div>
				<div class="fieldset">
					<a id="filtrar" class="button inline right blue" href="#">Filtrar</a>
				</div>
			</div>
			<div class="sec">
				<h2>Herramientas</h2>
				<a id="fullscreen" class="button" href="#">Ver pantalla completa</a>
			</div>
		</aside>

		<section>
			<div id="editmarks" class="pop">
				Edición de luminarias habilitada
			</div>
			<div class="sec">
				<ul id="list_filter" class="info">
					<li class="title">Filtros aplicados</li>
					<li id="fltr_all" class="filter">Buscar todas las luminarias</li>
				</ul>
				<ul class="info">
					<li class="found">Encontradas <span id="lumi_total"></span> luminarias (<span>100%</span>)</li>
					<li  class="result">De <span id="lumi_showing"></span> luminarias (<span id="lumi_percent"></span>)</li>
					<li  class="result">Potencia total del filteado: <span id="sumpo"></span> watts</li>
				</ul>
			</div>
			<div id="mapa">
			</div>
		</section>

	<a id="normalscreen" class="button blue" href="#">Regresar a pantalla normal</a>
	</div>
</body>
</html>