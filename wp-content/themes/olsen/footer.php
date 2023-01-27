</div><!-- /site-content -->
				<?php if ( ! is_page_template( 'template-blank.php') ) : ?>
					<footer id="footer">

						<?php if ( is_active_sidebar( 'footer-widgets') ) : ?>
							<?php
								$attributes = sprintf( 'data-auto="%s" data-speed="%s"',
									esc_attr( get_theme_mod( 'instagram_auto', 1 ) ),
									esc_attr( get_theme_mod( 'instagram_speed', 300 ) )
								);
							?>
							<div class="row">
								<div class="col-md-12">
									<div class="footer-widget-area" <?php echo $attributes; ?>>
										<?php dynamic_sidebar( 'footer-widgets' ); ?>
									</div>
								</div>
							</div>
						<?php endif; ?>				
					</footer><!-- /footer -->
<?php endif; ?>
<!-- /col-md-12 -->
		</div><!-- /row -->
	</div><!-- /container -->
</div><!-- #page -->
<?php wp_footer(); ?>

<script>
window.onscroll = function() {
            var top = window.pageYOffset || document.documentElement.scrollTop;
            if (top > 6) {
				let elemento1 = document.querySelector('#chingo');
			if(elemento1){
			   elemento1.classList.add("slidein");
			   }
                //document.querySelector('#chingo').classList.add("slideinOpacit");
            }
        }

        window.onload = function() {
			let elemento = document.querySelector('#chingo');
			if(elemento){
			   elemento.classList.add("slidein");
			   }
            
        }
		
		var elem = document.getElementById("acero");
		console.log(elem);

		function openFullscreen() {
		  if (elem.requestFullscreen) {
			elem.requestFullscreen();
		  } else if (elem.webkitRequestFullscreen) { /* Safari */
			elem.webkitRequestFullscreen();
		  } else if (elem.msRequestFullscreen) { /* IE11 */
			elem.msRequestFullscreen();
		  }
		}
    </script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
 <script>
AOS.init({
  once: false,
  mirror: false,
});
 </script>
</body>
<div class="todito">
<div class="cerra2">
	
<div class="pie3" id="paco"><p><img src="https://estudiovmm.com/wp-content/uploads/2021/01/logo-footer.png" alt="VMM Defensa Penal de la Empresa"></p>
	<a href="https://estudiovmm.com/politicas-de-privacidad/">Política de privacidad</a> 
	<a href="https://estudiovmm.com/terminos-y-condiciones/">Términos y condiciones</a>
	</div>
<div class="pie2">
<h4>EMPRESA</h4>
<a href="https://estudiovmm.com/">Inicio</a>
<a href="https://estudiovmm.com/nosotros/">La firma</a>
<a href="https://estudiovmm.com/equipo/">Especialistas</a>
<a href="https://estudiovmm.com/contacto/">Contacto</a>
</div>
<div class="pie2">
	<h4>SERVICIOS</h4>
<a href="https://estudiovmm.com/servicios/">Áreas de práctica</a>
<a href="https://estudiovmm.com/litigio/">Litigio</a>
<a href="https://estudiovmm.com/compliance-penal/">Compliance penal</a>
<a href="https://estudiovmm.com/asesoria/">Asesoría</a></div>
<div class="pie2">
	<h4>CONTENIDO</h4>
<a target="_blank" href="https://www.linkedin.com/company/morales-valverde-abogados">LinkedIn</a>
<a id="sumare" target="_blank" href="https://www.facebook.com/pages/Estudio-Valverde-Morales-Marticorena/103613278317612">Facebook</a>
	</div>
	<div id="pacopaco3">
	<div class="pepe" id="pacopaco2">
	<a href="https://estudiovmm.com/politicas-de-privacidad/">Política de privacidad</a> 
	<a href="https://estudiovmm.com/terminos-y-condiciones/">Términos y condiciones</a>
	</div>
	</div>
<div class="pie2 left">
<h4>DIRECCIÓN</h4>
<p>Jirón Cruz del Sur 140–154,</p>
<p>Oficina 1208, Santiago de Surco</p>
<p>(Edificio Time)</p>
<br>
	<p><strong>T:</strong>511 340 9386</p>
	<p><strong>C:</strong> contacto@estudiovmm.com</p></div>
</div>
</div>
	<div class="cierre" >
	<div class="anchito">
		<div id="feo"><p>
		2023 / VALVERDE, MORALES & MARTICORENA - Todos los derechos reservados
		</p></div>	
		<div id="feo" class="dere">
		<p>
		 Website diseñada por <img src="https://estudiovmm.com/wp-content/uploads/2021/01/mutante.png" alt="Mutante"></p></div>
	</div></div>
</html>

