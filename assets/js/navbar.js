/* ===================================
   NAVBAR MEJORADO - JAVASCRIPT
   Distribuidora Osvaldo
   Guardar como: assets/js/navbar-mejorado.js
   =================================== */

$(document).ready(function() {
    
    // ===================================
    // EFECTO SCROLL EN NAVBAR
    // ===================================
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('#mainNavbar').addClass('scrolled');
        } else {
            $('#mainNavbar').removeClass('scrolled');
        }
    });
    
    // ===================================
    // SCROLL INDICATOR (barra de progreso)
    // ===================================
    $(window).scroll(function() {
        const scrollTop = $(window).scrollTop();
        const docHeight = $(document).height();
        const winHeight = $(window).height();
        const scrollPercent = (scrollTop / (docHeight - winHeight)) * 100;
        $('#scrollIndicator').css('width', scrollPercent + '%');
    });
    
    // ===================================
    // SMOOTH SCROLL PARA ENLACES INTERNOS
    // ===================================
    $('.smooth-scroll, a[href^="#"]').on('click', function(e) {
        const target = $(this.hash);
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800, 'swing');
            
            // Cerrar menú móvil después del click
            if ($(window).width() < 768) {
                $('.navbar-collapse').collapse('hide');
            }
        }
    });
    
    // ===================================
    // CERRAR MENÚ AL HACER CLICK FUERA
    // ===================================
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.navbar').length) {
            $('.navbar-collapse').collapse('hide');
        }
    });
    
    // ===================================
    // HIGHLIGHT ACTIVO AL HACER SCROLL (ScrollSpy manual)
    // ===================================
    const sections = ['#historia', '#valores', '#contacto'];
    
    $(window).scroll(function() {
        const scrollPos = $(window).scrollTop() + 100;
        
        sections.forEach(function(section) {
            if ($(section).length) {
                const sectionTop = $(section).offset().top;
                const sectionBottom = sectionTop + $(section).outerHeight();
                
                if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                    $('.navbar-nav li').removeClass('active');
                    $('.navbar-nav a[href="' + section + '"]').parent().addClass('active');
                }
            }
        });
    });
    
    // ===================================
    // ANIMACIÓN DEL BADGE DEL CARRITO
    // ===================================
    let badgeCount = parseInt($('.badge').text()) || 0;
    
    // Simular actualización del badge (conectar con tu sistema real)
    function updateCartBadge(newCount) {
        const $badge = $('.navbar-nav .badge');
        
        if (newCount > 0) {
            $badge.text(newCount).show();
            $badge.addClass('badge-bounce');
            
            setTimeout(function() {
                $badge.removeClass('badge-bounce');
            }, 500);
        } else {
            $badge.hide();
        }
    }
    
    // ===================================
    // PREVENIR SCROLL HORIZONTAL
    // ===================================
    $('body').css('overflow-x', 'hidden');
    
    // ===================================
    // EFECTO DE CARGA INICIAL
    // ===================================
    $('#mainNavbar').addClass('loading');
    setTimeout(function() {
        $('#mainNavbar').removeClass('loading');
    }, 1000);
    
    // ===================================
    // ACCESIBILIDAD: NAVEGACIÓN CON TECLADO
    // ===================================
    $('.navbar-nav a').on('keydown', function(e) {
        // Tab entre links
        if (e.keyCode === 9) {
            // Comportamiento normal del tab
        }
        // Enter o Space para activar
        if (e.keyCode === 13 || e.keyCode === 32) {
            e.preventDefault();
            $(this).click();
        }
    });
    
    // ===================================
    // TOGGLE MEJORADO
    // ===================================
    $('.navbar-toggle').on('click', function() {
        $(this).toggleClass('active');
    });
    
    // ===================================
    // NOTIFICACIÓN EN WHATSAPP (Opcional)
    // ===================================
    $('.whatsapp-link').hover(
        function() {
            $(this).find('.notification-dot').fadeOut();
        },
        function() {
            $(this).find('.notification-dot').fadeIn();
        }
    );
});

// ===================================
// FUNCIÓN PÚBLICA: Actualizar contador carrito
// ===================================
function updateNavbarCart(count) {
    const $badge = $('.navbar-nav .badge');
    
    if (count > 0) {
        $badge.text(count).show();
        $badge.addClass('badge-bounce');
        setTimeout(() => $badge.removeClass('badge-bounce'), 500);
    } else {
        $badge.fadeOut();
    }
}