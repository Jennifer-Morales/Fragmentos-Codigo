add_action('wp_footer', 'modify_um_view_profile_link');
function modify_um_view_profile_link() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Busca enlaces que contengan el texto "Ver perfil" o "View profile"
        $('a:contains("Ver el perfil"), a:contains("View profile")').each(function() {
            // Cambia solo los enlaces que pertenezcan a Ultimate Member
            if ($(this).parents('.um').length > 0 || $(this).hasClass('um-button') || $(this).parents('.um-profile-nav').length > 0) {
                $(this).attr('href', 'https://grupometis.org/tejava/lp-perfil/');
            }
        });
    });
    </script>
    <?php
}