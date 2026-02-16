$(document).ready(function () {

    // CONFIGURACIÓN DEL CAROUSEL

    const carousel = $('#heroCarousel');

    // Reiniciar la barra de progreso en cada cambio de slide
    carousel.on('slide.bs.carousel', function () {
        $('.carousel-progress-bar').css('animation', 'none');
        setTimeout(function () {
            $('.carousel-progress-bar').css('animation', 'progress 5s linear');
        }, 10);
    });

    // PAUSAR ANIMACIÓN AL HOVER
    carousel.hover(
        function () {
            // Pausar
            $(this).addClass('paused');
            $('.carousel-progress-bar').css('animation-play-state', 'paused');
        },
        function () {
            // Reanudar
            $(this).removeClass('paused');
            $('.carousel-progress-bar').css('animation-play-state', 'running');
        }
    );

    // CONTROL CON TECLADO

    $(document).keydown(function (e) {
        // Flecha izquierda (37)
        if (e.keyCode === 37) {
            carousel.carousel('prev');
        }
        // Flecha derecha (39)
        if (e.keyCode === 39) {
            carousel.carousel('next');
        }
    });

    // SWIPE EN MÓVILES (Touch Events)

    let touchStartX = 0;
    let touchEndX = 0;

    carousel[0].addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    carousel[0].addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            // Swipe izquierda -> siguiente
            carousel.carousel('next');
        }
        if (touchEndX > touchStartX + 50) {
            // Swipe derecha -> anterior
            carousel.carousel('prev');
        }
    }

    // LAZY LOADING DE IMÁGENES

    carousel.on('slide.bs.carousel', function (e) {
        // Precargar la siguiente imagen
        const nextSlide = $(e.relatedTarget);
        const nextImg = nextSlide.find('img');

        if (nextImg.data('src')) {
            nextImg.attr('src', nextImg.data('src'));
            nextImg.removeAttr('data-src');
        }
    });

    // ANIMACIONES AOS (Opcional)
    // Si tienes AOS library instalada 

    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: false,
            mirror: true
        });
    }


    // SCROLL SUAVE AL HACER CLIC EN "VER PRODUCTOS"

    $('a[href="#main"]').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('#main').offset().top - 80
        }, 800, 'swing');
    });

    // INDICADOR DE CARGA INICIAL

    carousel.on('slid.bs.carousel', function () {
        // Añadir clase "loaded" después de la primera transición
        $(this).addClass('loaded');
    });


    // AUTO-REPRODUCIR AL ENTRAR EN VIEWPORT

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Carousel visible, iniciar
                carousel.carousel('cycle');
            } else {
                // Carousel oculto, pausar
                carousel.carousel('pause');
            }
        });
    }, { threshold: 0.5 });

    observer.observe(carousel[0]);

    // CONTADOR DE SLIDES ACTUAL/TOTAL

    const totalSlides = $('.carousel-item').length;
    let currentSlide = 1;

    // Crear contador si no existe
    if ($('.slide-counter').length === 0) {
        carousel.append(
            '<div class="slide-counter">' +
            '<span class="current">1</span> / ' +
            '<span class="total">' + totalSlides + '</span>' +
            '</div>'
        );
    }

    // Actualizar contador
    carousel.on('slide.bs.carousel', function (e) {
        currentSlide = $(e.relatedTarget).index() + 1;
        $('.slide-counter .current').text(currentSlide);
    });

    // EFECTO DE PARTÍCULAS

    function createParticles() {
        const particlesContainer = $('<div class="particles-container"></div>');
        carousel.append(particlesContainer);

        for (let i = 0; i < 30; i++) {
            const particle = $('<div class="particle"></div>');
            const size = Math.random() * 5 + 2;
            const duration = Math.random() * 10 + 10;
            const delay = Math.random() * 5;

            particle.css({
                width: size + 'px',
                height: size + 'px',
                left: Math.random() * 100 + '%',
                animationDuration: duration + 's',
                animationDelay: delay + 's'
            });

            particlesContainer.append(particle);
        }
    }

    createParticles();


    // LOG DE DEBUG (Desarrollo)

    if (window.location.hostname === 'localhost') {
        carousel.on('slid.bs.carousel', function (e) {
            console.log('Slide actual:', $(e.relatedTarget).index() + 1);
        });
    }

    // FIX PARA MÓVILES: EVITAR SCROLL VERTICAL AL HACER SWIPE

    carousel[0].addEventListener('touchmove', function (e) {
        e.preventDefault();
    }, { passive: false });

});

// FUNCIONES GLOBALES

// Función para cambiar intervalo dinámicamente
function setCarouselInterval(milliseconds) {
    $('#heroCarousel').carousel({
        interval: milliseconds
    });
}

// Función para ir a un slide específico
function goToSlide(slideNumber) {
    $('#heroCarousel').carousel(slideNumber - 1);
}

// Función para pausar/reanudar manualmente
function toggleCarousel() {
    const carousel = $('#heroCarousel');
    if (carousel.hasClass('paused')) {
        carousel.carousel('cycle');
        carousel.removeClass('paused');
    } else {
        carousel.carousel('pause');
        carousel.addClass('paused');
    }
}