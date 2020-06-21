
			var actual = 0;
			function puntos(n){
				var ptn = document.getElementsByClassName("punto-carrusel");
				for(i = 0; i<ptn.length; i++){
					if(ptn[i].className.includes("activo-carrusel")){
						ptn[i].className = ptn[i].className.replace("activo-carrusel", "");
						break;
					}
				}
				ptn[n].className += " activo-carrusel";
			}
			function mostrar(n){
				var imagenes = document.getElementsByClassName("imagen-carrusel");
				for(i = 0; i< imagenes.length; i++){
					if(imagenes[i].className.includes("actual-carrusel")){
						imagenes[i].className = imagenes[i].className.replace("actual-carrusel", "");
						break;
					}
				}
				actual = n;
				imagenes[n].className += " actual-carrusel";
				puntos(n);
			}
			
			function siguiente(){
				actual++;
				if(actual > 3){
					actual = 0;
				}
				mostrar(actual);
			}
			function anterior(){
				actual--;
				if(actual < 0){
					actual = 3;
				}
				mostrar(actual);
			}