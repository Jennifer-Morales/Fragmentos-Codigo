function mostrar_estudiantes_del_curso( $atts ) {
    $atts = shortcode_atts( array(
        'curso_id' => 895,
    ), $atts );

    $curso_id = $atts['curso_id'];
    global $wpdb;

    // Obtener estudiantes inscritos al curso
    $consulta = "
        SELECT u.ID, u.user_login, u.user_email, u.display_name
        FROM {$wpdb->users} u
        INNER JOIN {$wpdb->prefix}learnpress_user_items ui ON u.ID = ui.user_id
        WHERE ui.item_id = %d 
        AND ui.item_type = 'lp_course' 
        AND ui.status = 'enrolled'
    ";

    $estudiantes = $wpdb->get_results( $wpdb->prepare( $consulta, $curso_id ) );

    if ( empty( $estudiantes ) ) {
        return 'No hay estudiantes inscritos en este curso.';
    }

    ob_start();

    echo '<h4>Estudiantes Inscritos en el Curso</h4>';
    echo '<table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">';
	echo '<thead style="background-color: #004d73; color: white;">';
    echo '<tr><th>Estudiante</th><th>Correo</th><th>Perfil</th></tr>';
	echo '</thead><tbody>';

    foreach ( $estudiantes as $estudiante ) {
        // Validar que el objeto sea correcto
        if ( ! isset( $estudiante->ID ) || empty( $estudiante->ID ) ) {
            continue;
        }

        $usuario = get_userdata( $estudiante->ID );
        if ( ! $usuario || in_array( 'administrator', (array) $usuario->roles ) ) {
            continue;
        }

        $perfil_url = site_url( '/lp-perfil/' . $estudiante->user_login );

        echo '<tr>';
        echo '<td>' . esc_html( $estudiante->display_name ) . '</td>';
        echo '<td>' . esc_html( $estudiante->user_email ) . '</td>';
        echo '<td><a href="' . esc_url( $perfil_url ) . '" target="_blank" style="color: #009fe3;">Ver Perfil</a></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    return ob_get_clean();
}
add_shortcode( 'estudiantes_curso', 'mostrar_estudiantes_del_curso' );