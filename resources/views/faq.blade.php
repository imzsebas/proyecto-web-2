<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Servicios / MiRefugio</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="{{ route('home') }}">Mi Refugio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"><span
                        class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Quienes Somos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contactanos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">Servicios</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="fw-bolder">Preguntas Frecuentes - Apoyo Psicológico</h1>
                    <p class="lead fw-normal text-muted mb-0">¿Cómo podemos ayudarte?</p>
                </div>
                <div class="row gx-5">
                    <div class="col-xl-8">
                        <h2 class="fw-bolder mb-3">Servicios y Terapias</h2>
                        <div class="accordion mb-5" id="accordionExample">
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="headingOne"><button class="accordion-button"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">¿Qué tipos de terapia
                                        ofrecen?</button></h3>
                                <div class="accordion-collapse collapse show" id="collapseOne"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Nuestro equipo especializado ofrece diversos enfoques terapéuticos adaptados a
                                        tus necesidades:<br />
                                        <br /><strong>Terapia Cognitivo-Conductual (TCC): </strong>Ayuda a identificar y
                                        cambiar patrones de pensamiento negativos que influyen en tu comportamiento y
                                        emociones.
                                        Terapia Humanista: Centrada en tu desarrollo personal y potencial humano,
                                        fomentando la autoaceptación y el crecimiento.
                                        <br><strong>Mindfulness y técnicas de relajación: </strong>Herramientas
                                        prácticas para gestionar el estrés y la ansiedad en tu día a día.
                                        Terapia para trauma (EMDR): Enfoque especializado para procesar experiencias
                                        traumáticas.

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                        aria-expanded="false" aria-controls="collapseTwo">¿Cómo sé qué tipo de terapia
                                        necesito?</button></h3>
                                <div class="accordion-collapse collapse" id="collapseTwo" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Durante tu primera sesión de evaluación, nuestros profesionales te ayudarán a
                                        determinar el enfoque más adecuado
                                        según tus circunstancias específicas. No necesitas saberlo de antemano - estamos
                                        aquí para guiarte. Cada persona
                                        es única, por lo que personalizamos nuestro enfoque terapéutico considerando tus
                                        objetivos, historial y preferencias
                                        personales.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="headingThree"><button
                                        class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">¿Cuánto duran las sesiones de terapia?</button>
                                </h3>
                                <div class="accordion-collapse collapse" id="collapseThree"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Las sesiones individuales suelen durar 50-60 minutos. Las terapias de pareja o
                                        familiares pueden extenderse hasta 90
                                        minutos. La frecuencia recomendada es semanal al inicio del proceso terapéutico,
                                        pudiendo espaciarse según tu progreso
                                        y necesidades. Trabajamos contigo para establecer un plan que se adapte a tu
                                        situación particular.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h2 class="fw-bolder mb-3">Problemas Comunes</h2>
                        <div class="accordion mb-5 mb-xl-0" id="accordionExample2">
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="headingOne"><button class="accordion-button"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2"
                                        aria-expanded="true" aria-controls="collapseOne2">¿Cómo puedo manejar la
                                        ansiedad?</button></h3>
                                <div class="accordion-collapse collapse show" id="collapseOne2"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        La ansiedad es una respuesta natural del cuerpo ante situaciones de estrés o
                                        peligro percibido. Para gestionarla efectivamente:
                                        <br>
                                        <br><strong>Mindfulness:</strong> Enfócate en el momento presente y en tus
                                        sensaciones corporales sin juzgarlas.
                                        <br><strong>Actividad física regular:</strong> El ejercicio libera endorfinas y
                                        reduce hormonas del estrés.
                                        <br><strong>Limita estimulantes:</strong> Reduce el consumo de cafeína, alcohol
                                        y azúcares refinados.
                                        <br><strong>Establece rutinas:</strong> La predictibilidad ayuda a reducir la
                                        incertidumbre que alimenta la ansiedad.
                                        <br><strong>Técnicas de respiración:</strong> Practica la respiración
                                        diafragmática: inhala lentamente contando hasta 4, <br> mantén el aire 2
                                        segundos, y exhala contando hasta 6.
                                        <br><br>
                                        Recuerda que la ansiedad persistente que interfiere con tu vida diaria merece
                                        atención profesional. Nuestros especialistas pueden ayudarte con estrategias
                                        personalizadas y efectivas.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="headingTwo"><button class="accordion-button collapsed"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo2"
                                        aria-expanded="false" aria-controls="collapseTwo2">¿Cómo reconocer signos de
                                        depresión?</button></h3>
                                <div class="accordion-collapse collapse" id="collapseTwo2" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        La depresión va más allá de sentirse triste ocasionalmente. Algunos signos que
                                        podrían indicar depresión incluyen:
                                        <br>
                                        <br><strong>-></strong> Sentimientos persistentes de tristeza, vacío o
                                        desesperanza durante al menos dos semanas
                                        <br><strong>-></strong> Pérdida de interés en actividades que antes disfrutabas
                                        <br><strong>-></strong> Cambios significativos en el apetito y peso
                                        <br><strong>-></strong> Alteraciones del sueño (insomnio o hipersomnia)
                                        <br><strong>-></strong> Fatiga o pérdida de energía casi todos los días
                                        <br><strong>-></strong> Sentimientos de inutilidad o culpa excesiva
                                        <br><strong>-></strong> Dificultad para concentrarse o tomar decisiones
                                        <br><strong>-></strong> Pensamientos recurrentes sobre la muerte o el suicidio
                                        <br><br>
                                        Si experimentas varios de estos síntomas, te recomendamos buscar ayuda
                                        profesional. La depresión es tratable y nuestro equipo está preparado para
                                        apoyarte en este proceso.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="headingThree"><button
                                        class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree2" aria-expanded="false"
                                        aria-controls="collapseThree2">¿Qué puedo hacer para mejorar mis relaciones
                                        interpersonales?</button></h3>
                                <div class="accordion-collapse collapse" id="collapseThree2"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample2">
                                    <div class="accordion-body">
                                        Las relaciones saludables son fundamentales para nuestro bienestar emocional.
                                        Algunos consejos prácticos:
                                        <br><br>
                                        <br><strong>Desarrolla habilidades de comunicación:</strong> Aprende a expresar
                                        tus necesidades y emociones de manera asertiva, sin agresividad ni pasividad.
                                        <br><strong>Practica la escucha activa:</strong> Presta verdadera atención a lo
                                        que otros dicen, sin interrumpir o preparar tu respuesta mientras hablan.
                                        <br><strong>Establece límites saludables:</strong> Define claramente lo que es
                                        aceptable y lo que no en tus relaciones.
                                        <br><strong>Cultiva la empatía:</strong> Intenta comprender las perspectivas y
                                        sentimientos de los demás.
                                        <br><Strong>Resuelve conflictos constructivamente:</Strong> Aborda los
                                        desacuerdos con respeto, buscando soluciones en lugar de culpables.
                                        <br><br>
                                        En nuestras sesiones, podemos trabajar específicamente en las áreas que
                                        representan un desafío para ti.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card border-0 bg-light mt-xl-5">
                            <div class="card-body p-4 py-lg-5">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <div class="h6 fw-bolder">¿Tienes más preguntas?</div>
                                        <p class="text-muted mb-4">
                                            Contactanos
                                            <br />
                                            <a href="#!">mirefugio@gmail.com</a>
                                        </p>
                                        <div class="h6 fw-bolder">Siguenos</div>
                                        <a class="fs-5 px-2 link-dark" href="#!"><i class="bi-twitter"></i></a>
                                        <a class="fs-5 px-2 link-dark" href="#!"><i class="bi-facebook"></i></a>
                                        <a class="fs-5 px-2 link-dark" href="#!"><i class="bi-instagram"></i></a>
                                        <a class="fs-5 px-2 link-dark" href="#!"><i class="bi-youtube"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Proyecto Desarrollo web 2 &copy; MiRefugio 2025</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>