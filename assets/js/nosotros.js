/* ===================================
   NOSOTROS.PHP - JAVASCRIPT COMPLETO
   Distribuidora Osvaldo
   Guardar como: assets/js/nosotros.js
   =================================== */

$(document).ready(function() {
    
    // ===================================
    // ANIMACIÓN DE CONTADORES
    // ===================================
    function animateCounters() {
        $('.stat-number[data-count]').each(function() {
            const $this = $(this);
            const count = parseInt($this.attr('data-count'));
            const suffix = $this.text().replace(/[0-9]/g, '');
            
            $({ Counter: 0 }).animate({ Counter: count }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.ceil(this.Counter) + suffix);
                }
            });
        });
    }

    // Activar cuando sea visible
    $(window).scroll(function() {
        const estadisticas = $('.estadisticas-section');
        if (estadisticas.length && !estadisticas.hasClass('animated')) {
            const scrollTop = $(window).scrollTop();
            const elemTop = estadisticas.offset().top;
            const windowHeight = $(window).height();
            
            if (scrollTop + windowHeight > elemTop + 100) {
                estadisticas.addClass('animated');
                animateCounters();
            }
        }
    });

    // ===================================
    // SCROLL TO TOP BUTTON
    // ===================================
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#scrollToTop').addClass('visible');
        } else {
            $('#scrollToTop').removeClass('visible');
        }
    });

    $('#scrollToTop').click(function() {
        $('html, body').animate({scrollTop: 0}, 600);
    });

    // ===================================
    // SMOOTH SCROLL PARA ENLACES INTERNOS
    // ===================================
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.hash);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });

    // ===================================
    // LAZY LOADING DE IMÁGENES (FALLBACK)
    // ===================================
    if ('loading' in HTMLImageElement.prototype) {
        console.log('Browser supports lazy loading');
    } else {
        // Cargar polyfill si es necesario
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
    
    // ===================================
    // ANIMACIÓN DE ENTRADA DE ELEMENTOS
    // ===================================
    function animateOnScroll() {
        $('.valor-item, .mision-vision-card, .card-multimedia').each(function() {
            const elementTop = $(this).offset().top;
            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();
            
            if (scrollTop + windowHeight > elementTop + 50) {
                $(this).addClass('animate-fadeInUp');
            }
        });
    }
    
    $(window).scroll(animateOnScroll);
    animateOnScroll(); // Ejecutar al cargar
    
    // ===================================
    // EFECTO PARALLAX EN HERO
    // ===================================
    $(window).scroll(function() {
        const scrolled = $(window).scrollTop();
        $('.nosotros-hero').css('transform', 'translateY(' + (scrolled * 0.3) + 'px)');
    });
    
    // ===================================
    // TOOLTIP EN BOTONES
    // ===================================
    $('[title]').tooltip({
        placement: 'top',
        trigger: 'hover'
    });
    
    // ===================================
    // VALIDACIÓN DE VIDEO
    // ===================================
    $('video').on('error', function() {
        $(this).replaceWith('<p style="padding: 20px; text-align: center; color: #7f8c8d;">Video no disponible</p>');
    });
    
    // ===================================
    // CONTADOR DE VISITAS (Opcional - guardar en localStorage)
    // ===================================
    if (typeof(Storage) !== "undefined") {
        let visits = localStorage.getItem('nosotros_visits') || 0;
        visits++;
        localStorage.setItem('nosotros_visits', visits);
        console.log('Visitas a página Nosotros: ' + visits);
    }
    
    // ===================================
    // TRACKING DE CLICKS EN REDES SOCIALES
    // ===================================
    $('.btn-facebook, .btn-instagram').click(function() {
        const socialNetwork = $(this).hasClass('btn-facebook') ? 'Facebook' : 'Instagram';
        console.log('Click en ' + socialNetwork);
        
        // Aquí puedes agregar Google Analytics o similar
        // ga('send', 'event', 'Social', 'Click', socialNetwork);
    });
    
    // ===================================
    // PRELOADER (Opcional)
    // ===================================
    $(window).on('load', function() {
        $('#preloader').fadeOut('slow');
    });
});

// ===================================
// FUNCIONES PÚBLICAS
// ===================================

// Función para mostrar notificación
function showNotification(message, type = 'info') {
    const notification = $('<div>', {
        class: 'notification notification-' + type,
        text: message
    });
    
    $('body').append(notification);
    notification.fadeIn();
    
    setTimeout(function() {
        notification.fadeOut(function() {
            $(this).remove();
        });
    }, 3000);
}

// Función para compartir en redes sociales
function shareOnSocial(network) {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('Conoce más sobre Distribuidora Osvaldo');
    
    let shareUrl;
    
    switch(network) {
        case 'facebook':
            shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
            break;
        case 'twitter':
            shareUrl = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + text;
            break;
        case 'whatsapp':
            shareUrl = 'https://wa.me/?text=' + text + ' ' + url;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

// Función para imprimir página
function printPage() {
    window.print();
}