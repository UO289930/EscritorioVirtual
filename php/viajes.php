<?php

    class Carrusel{

        const NFOTOS = 10;

        private $nombre_capital;
        private $nombre_pais;
        private $fotos = array();

        public function __construct($nombre_capital, $nombre_pais){
            $this->nombre_capital = $nombre_capital;
            $this->nombre_pais = $nombre_pais;
        }

        public function findFotos(){
            $params = array(
                'method'	     => 'flickr.photos.search',
                'api_key'	     => '49cbf95f9fa6eeaed933058baa0a8d88',
                'tags'           => $this->nombre_pais . "," . $this->nombre_capital,
                'tagmode'        => 'any',
                'format'         => 'php_serial',
                'nojsoncallback' => 1
            );
            
            $encoded_params = array();

            foreach ($params as $k => $v){

                $encoded_params[] = urlencode($k).'='.urlencode($v);
            }
            
            $url = 'https://api.flickr.com/services/rest/?'.implode('&', $encoded_params);

            $rsp = file_get_contents($url);
            $rsp_obj = unserialize($rsp);

            if ($rsp_obj['stat'] == 'ok' && isset($rsp_obj['photos']['photo'])){

                $arrayFotos = $rsp_obj['photos']['photo'];
                $arrayLength = count($arrayFotos);
                $size = self::NFOTOS > $arrayLength ? $arrayLength : self::NFOTOS;

                for($i = 0; $i < $size; $i++){
                    # https://live.staticflickr.com/{server-id}/{id}_{secret}_{size-suffix}.jpg
                    # b es 1024 px sin secreto
                    $foto = $arrayFotos[$i];
                    $this->fotos[] = 'https://live.staticflickr.com/'.$foto['server'].'/'.$foto['id'].'_'.$foto['secret'].'_b.jpg';
                }
            }
        }

        public function getFotos(){
            $i = 1;
            foreach($this->fotos as $foto){
                echo '<img src="'.$foto.'" alt="Foto '.$i++.' de '.$this->nombre_pais.'" />' ;
            }
        }

    }

    class Moneda{

        # API : https://app.exchangerate-api.com/dashboard
        # 1500 peticiones y 2 meses
        const API_URL= "https://v6.exchangerate-api.com/v6/b1c7f1ea5929e191041c68f1/latest/";
        private $code_to;
        private $code_from;

        public function __construct($code_to, $code_from){
            $this->code_to = $code_to;
            $this->code_from = $code_from;
        }

        public function getCambio(){
            $url = self::API_URL . $this->code_from;
            $respuesta = file_get_contents($url);
            $json = json_decode($respuesta);

            if($json!=null) {
                echo "<p>El valor de 1 ". $this->code_from ." es " . $json->conversion_rates->{$this->code_to} . " " . $this->code_to . " en Brunéi.</p>";
            }
            else {
                echo "<p>Hubo un problema en el cálculo de las divisas de ". $this->code_from . " a " . $this->code_to . ".</p>";
            }

        }
    }
    
    # Carrusel
    $c = new Carrusel("Begawan", "Brunéi");
    $c->findFotos();

    # Moneda (BND === Dolar Bruneano)
    $m = new Moneda("BND", "EUR");
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name ="author" content ="Sergio Truébano Robles" />
    <meta name ="description" content ="Viajes" />
    <meta name ="keywords" content ="viajes,mapa,ruta,archivos,Brunei" />
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <title>Escritorio Virtual - Viajes</title>

    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css" />
    <link rel="stylesheet" href="../estilo/viajes.css" />
    <link rel="icon" href="../multimedia/imagenes/favicon.ico" />
    <!-- CSS de la API de mapbox-->
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" />

    <!-- link de enlace jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--API de mapbox para usar el mapa dinámico-->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
    <!-- link de enlace javascript -->
    <script src="../js/viajes.js"></script>
</head>
    
<body>

    <header>
        <h1>Escritorio Virtual</h1>
        <nav>
            <a href="../index.html" title="Índice" accesskey="I" tabindex="1">Inicio</a>
            <a href="../sobremi.html" title="Sobre mi" accesskey="S" tabindex="2">Sobre mi</a>
            <a href="../noticias.html" title="Noticias" accesskey="N" tabindex="3">Noticias</a>
            <a href="../agenda.html" title="Agenda" accesskey="A" tabindex="4">Agenda</a>
            <a href="../meteorologia.html" title="Meteorología" accesskey="M" tabindex="5">Meteorología</a>
            <a href="viajes.php" title="Viajes" accesskey="V" tabindex="6">Viajes</a>
            <a href="../juegos.html" title="Juegos" accesskey="J" tabindex="7">Juegos</a>
        </nav>
    </header>
    

    <main>
        <h2>Viajes</h2>

        <section data-element="carrusel"> 
            <h3>Imágenes de Brunéi</h3>
            <?php $c->getFotos(); ?>
            <button data-action="next" title="Siguiente foto" onclick="viajes.nextFoto();" tabindex="8"> > </button>
            <button data-action="prev" title="Foto anterior" onclick="viajes.prevFoto();" tabindex="9"> < </button>
        </section>

        <article data-element="exchange">
            <h3>Divisas</h3>
            <?php $m->getCambio() ?>
        </article>

        <section data-element="xml">
            <h3>Rutas</h3>
            <p>
                <label for="xml-in">Selecciona un archivo XML para mostrar su contenido:</label>
                <input id="xml-in" type="file" onchange="viajes.parseInputFile(this.files);" title="Seleccionador de archivo XML" tabindex="10">
            </p>
        </section>

        <section data-element="kml">
            <h3>Planimetrías</h3>
            <p>
                <label for="kml-in">Selecciona varios archivos KML para mostrar su contenido:</label>
                <input id="kml-in" type="file" onchange="viajes.parseInputKmlFiles(this.files);" title="Seleccionador de archivos KML" multiple tabindex="11">
            </p>
        </section>

        <section data-element="svg">
            <h3>Altimetrías</h3>
            <p>
                <label for="svg-in">Selecciona varios archivos SVG para mostrar su contenido:</label>
                <input id="svg-in" type="file" onchange="viajes.parseInputSvgFiles(this.files);" title="Seleccionador de archivos KML" multiple tabindex="12">
            </p>
        </section>

    </main>

</body>
</html>