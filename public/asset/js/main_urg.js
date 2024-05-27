contratoMarcoSub();

function contratoMarcoSub(){
	const $dropdown = $(".dropdown");
	const $dropdownToggle = $(".dropdown-toggle");
	const $dropdownMenu = $(".dropdown-menu");
	const showClass = "show";
	$(window).on("load resize", function () {
	    if (this.matchMedia("(min-width: 768px)").matches) {
	        $dropdown.hover(
	            function () {
	                const $this = $(this);
	                $this.addClass(showClass);
	                $this.find($dropdownToggle).attr("aria-expanded", "true");
	                $this.find($dropdownMenu).addClass(showClass);
	            },
	            function () {
	                const $this = $(this);
	                $this.removeClass(showClass);
	                $this.find($dropdownToggle).attr("aria-expanded", "false");
	                $this.find($dropdownMenu).removeClass(showClass);
	            }
	        );
	    } else {
	        $dropdown.off("mouseenter mouseleave");
	    }
	});

	$.ajax({
	    type: "GET",
	    url: url + 'tienda_urg/cargar_contratosm',
	    success: function (datos) {
	   		
	        let contenido = "";
	        for (let i = 0; i < datos.datos.length; i++) {
	            contenido += `<li class="dropdown">
	            					<a id='buscar_contrato_${i}' class='dropdown'>
	                            		${datos.datos[i].nombre_cm}
	                        			<div style="float: right"><i class="fa fa-angle-right"></i></div>
	                        		</a>
	                        	</li>`;

	            $(document).on("click", `#buscar_contrato_${i}`, function (e) {
	                e.preventDefault();
	                localStorage.setItem('cm', datos.datos[i].id_e);
	                localStorage.setItem('nombre', datos.datos[i].nombre_cm);
        			window.location = url + "tienda_urg/ver_tienda/";
	            });
	        }

	        document.querySelector("#dr").innerHTML = contenido;
	    },
	});
}