<?php



// Theme Prepare
add_action('after_setup_theme', 'ryt_setup');
function ryt_setup()
{
    register_nav_menus(array('mobile-menu' => esc_html__('Mobile Menu', 'blankslate')));
    register_nav_menus(array('footer-menu' => esc_html__('Footer Menu', 'blankslate')));
}

/// Menu Settings into admin panel
function add_additional_class_on_li($classes, $item, $args)
{
    if (isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);


//Desactivar TopBar de WP
add_filter('show_admin_bar', '__return_false');

//Alpine JS
function alpine_js()
{
    wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'alpine_js');


//Tailwind CSS
function enqueue_styles_child_theme()
{

    $parent_style = 'parent-style';
    $child_style = 'child-style';

    wp_enqueue_style(
        $parent_style,
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        $child_style,
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style('tailwind-css', get_stylesheet_directory_uri() . '/tailwindcss/output.css');
}
add_action('wp_enqueue_scripts', 'enqueue_styles_child_theme');



//FontAwesome
function load_font_awesome()
{
    wp_register_script('font-awesome', 'https://kit.fontawesome.com/b829081f82.js', array(), null, true);
    wp_enqueue_script('font-awesome');
}

add_action('wp_enqueue_scripts', 'load_font_awesome');



//Fuentes
function typografy_link()
{
    wp_register_style("raleway", "https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700&display=swap", array(), "1.0", "all");
    wp_enqueue_style("raleway");
}
add_action('wp_enqueue_scripts', 'typografy_link');



//Filter para el serach.php "Sort by"
function custom_search_filters($query)
{
    if ($query->is_main_query() && !is_admin()) {
        // Obtener el valor del parámetro 'orderby' de la URL
        $orderby = filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($orderby) {
            // Si se está ordenando por el campo Rating
            if ($orderby === 'rating') {
                $query->set('meta_key', 'Rating'); // El nombre de tu campo personalizado
                $query->set('orderby', 'meta_value_num'); // Ordenar como un número
                $query->set('order', 'DESC'); // Orden descendente por defecto
            } else {
                $query->set('orderby', $orderby);
                $query->set('order', ($orderby === 'title') ? 'ASC' : 'DESC'); // Ascendente para título
            }
        }
    }
}
add_action('pre_get_posts', 'custom_search_filters');



// Guardar campos personalizados en el meta de los comentarios "Proof y Rate" Admin Panel
function save_custom_comment_meta($comment_id)
{
    // Guardar el campo 'stars' (estrellas)
    if (isset($_POST['stars'])) {
        update_comment_meta($comment_id, 'stars', intval($_POST['stars']));
    }
}
add_action('edit_comment', 'save_custom_comment_meta');

// Mostrar los campos personalizados en la vista de comentarios en el panel de administración
function display_custom_fields_in_comment_list($comment_text, $comment)
{
    if (get_post_type($comment->comment_post_ID) === 'therapists') { // Verifica si es del post type 'therapists'
        // Obtener el valor de las estrellas con UCF
        $rate = get_comment_meta($comment->comment_ID, 'rate', true);
        $proof_id = get_comment_meta($comment->comment_ID, 'proof', true);

        if ($rate || $proof_id) {
            // Mostrar 'stars' como texto
            if ($rate) {
                $comment_text .= '<p><strong>Rate:</strong> ' . esc_html($rate) . ' estrellas</p>';
            }

            // Mostrar 'proof' (como un enlace al archivo)
            if ($proof_id) {
                $proof_url = wp_get_attachment_url($proof_id); // Obtener la URL del archivo
                $comment_text .= '<p><strong>Proof:</strong> <a href="' . esc_url($proof_url) . '" target="_blank">Ver archivo</a></p>';
            }
        }
    }

    return $comment_text;
}
add_filter('comment_text', 'display_custom_fields_in_comment_list', 10, 2);



//Search.php

///Limitar busqueda
function custom_search_query($query)
{
    // Verifica si estamos en la página de búsqueda y si no es una consulta de administración
    if ($query->is_search() && !is_admin()) {
        // Limita a 5 resultados por página
        $query->set('posts_per_page', 5);
    }
    return $query;
}
add_filter('pre_get_posts', 'custom_search_query');




//Calculo de Rating para el rating que se almacenará de el field "Rating" del terapeuta
function calculate_post_rating($post_id)
{
    // Obtener los comentarios aprobados del post
    $comments = get_approved_comments($post_id);

    $total_stars = 0;
    $comment_count = 0;

    // Recorrer los comentarios aprobados y sumar las valoraciones
    foreach ($comments as $comment) {
        $rate = get_comment_meta($comment->comment_ID, 'rate', true); // Obtener la calificación del comentario
        if ($rate) {
            $total_stars += (float) $rate;
            $comment_count++;
        }
    }

    // Calcular el promedio sin redondeo
    $average_rate = ($comment_count > 0) ? round($total_stars / $comment_count, 1) : 0;

    // Actualizar el rating en la base de datos del post
    update_post_meta($post_id, 'Rating', $average_rate);

    // Registrar el promedio calculado en el log para depuración
    error_log('Promedio calculado para el post ' . $post_id . ': ' . $average_rate);
}

// Activar el cálculo de la calificación cuando cambia el estado de un comentario
function update_post_rating_on_comment_status_change($comment_id, $comment_status)
{
    // Verificamos que el comentario existe
    $comment = get_comment($comment_id);

    // Si no existe el comentario, no hacer nada
    if (!$comment) {
        return;
    }

    $post_id = $comment->comment_post_ID;

    // Solo recalcular el rating cuando el estado cambia a aprobado o desaprobado
    if ($comment_status === 'approve' || $comment_status === 'hold') {
        // Llamar a la función para recalcular el rating del post
        calculate_post_rating($post_id);
    }
}

// Añadir la acción al hook que se activa cuando cambia el estado de un comentario
add_action('wp_set_comment_status', 'update_post_rating_on_comment_status_change', 10, 2);






//// Filtro por estrellas en Search.php

add_action('pre_get_posts', function ($query) {
    // Asegúrate de que no sea admin y sea la consulta principal
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // Verifica si se está usando el parámetro 'stars'
    if (isset($_GET['stars']) && is_search()) {
        $stars = intval($_GET['stars']);
        $min_rating = $stars;
        $max_rating = $stars == 5 ? 5 : $stars + 0.9;

        // Modifica la consulta
        $meta_query = [
            [
                'key'     => 'Rating',
                'value'   => [$min_rating, $max_rating],
                'compare' => 'BETWEEN',
                'type'    => 'DECIMAL',
            ],
        ];
        $query->set('meta_query', $meta_query);
    }
});



// Filtro por estrellas Categorías
add_action('pre_get_posts', function ($query) {
    // Asegúrate de que no sea admin y sea la consulta principal
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // Verifica si se está usando el parámetro 'stars' y si es una página de archivo
    if (isset($_GET['stars'])) {
        $stars = intval($_GET['stars']);
        $min_rating = $stars;
        $max_rating = $stars == 5 ? 5 : $stars + 0.9;

        // Modifica la consulta
        $meta_query = [
            [
                'key'     => 'Rating', // Asegúrate de que el campo de rating sea 'Rating' o el que estés utilizando
                'value'   => [$min_rating, $max_rating],
                'compare' => 'BETWEEN',
                'type'    => 'DECIMAL',
            ],
        ];

        // Agrega el meta_query a la consulta
        $query->set('meta_query', $meta_query);
    }
});



// Función que limita a solo mostrar entradas de tipo 'therapists' en la búsqueda "SearchEngine"
function filter_search_therapists($query)
{
    // Verifica que estamos en el loop principal y que es una búsqueda
    if (!is_admin() && $query->is_main_query() && is_search()) {
        // Modifica la consulta para solo traer el custom post type 'therapists'
        $query->set('post_type', 'therapists');
    }
}
add_action('pre_get_posts', 'filter_search_therapists');




// Personalización de comentarios

// Agregar soporte para la paginación de comentarios
function custom_comment_class($args)
{
    // Añadir una función de callback personalizada
    $args['callback'] = 'my_custom_comment_callback';

    return $args;
}
add_filter('wp_list_comments_args', 'custom_comment_class');

// Función personalizada para generar el HTML de los comentarios
function my_custom_comment_callback($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    require_once get_stylesheet_directory() . "/components/comments/single-comment.php";  //Diseño de los comentarios en la ruta correspondiente

    echo SingleComment($args, $depth);  //Llamado a la función que contiene el template para los comentarios
}


// Ordenar los comentarios por diferentes criterios
add_filter('comments_clauses', function ($clauses, $comment_query) {
    if (!is_admin() && isset($_GET['orderby'])) {
        global $wpdb;
        $orderby = sanitize_text_field($_GET['orderby']);

        // Si se ordena por 'useful'
        if ($orderby === 'useful') {
            // Se agrega un LEFT JOIN para obtener el valor de 'useful' en los comentarios
            $clauses['join'] .= "
                LEFT JOIN {$wpdb->commentmeta} AS cm_useful ON {$wpdb->comments}.comment_ID = cm_useful.comment_id
                AND cm_useful.meta_key = 'useful'
            ";
            // Ordenamos por el valor de 'useful' (conversión a número) y por fecha
            $clauses['orderby'] = "CAST(cm_useful.meta_value AS UNSIGNED) DESC, {$wpdb->comments}.comment_date_gmt DESC";
        }
        // Si se ordena por 'oldest' (comentarios más antiguos primero)
        elseif ($orderby === 'oldest') {
            $clauses['orderby'] = "{$wpdb->comments}.comment_date_gmt ASC";
        }
        // Si no hay filtro o es otro tipo, ordenamos por la fecha más reciente
        else {
            $clauses['orderby'] = "{$wpdb->comments}.comment_date_gmt DESC";
        }
    }

    return $clauses;
}, 10, 2);



// Redirigir a la URL con "orderby=newest" por defecto solo en la página single esto asegura que se muestren los comentarios mas nuevos primero.
add_action('template_redirect', function () {
    if (is_single() && !isset($_GET['orderby'])) {
        // Redirigir con el parámetro 'orderby=newest' solo si no está presente en la URL
        wp_redirect(add_query_arg('orderby', 'newest', home_url(add_query_arg(array()))));
        exit();
    }
});


//Custom Login Ajax
function handle_login_ajax()
{
    // Verificar si las credenciales se han enviado
    if (isset($_POST['log']) && isset($_POST['pwd'])) {
        $creds = array(
            'user_login'    => $_POST['log'],
            'user_password' => $_POST['pwd'],
            'remember'      => $_POST['rememberme'] === 'on'
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            echo json_encode(array('success' => false));
        } else {
            echo json_encode(array('success' => true)); // Si el login es exitoso devuelve true y la redirrección se hace desde el frontend
        }
    }
    die();
}

add_action('wp_ajax_login_action', 'handle_login_ajax'); // Para usuarios logueados
add_action('wp_ajax_nopriv_login_action', 'handle_login_ajax'); // Para usuarios no logueados


//Custom Register Ajax
function custom_register_action()
{
    // Verificar el nonce para seguridad
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'register_nonce')) {
        wp_send_json_error(array('message' => 'Nonce validation failed.'));
    }

    // Recibir los datos del formulario
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);

    // Validar que el correo no esté en uso
    if (email_exists($email)) {
        wp_send_json_error(array('message' => 'The email is already registered.'));
    }

    // Crear el nuevo usuario
    $userdata = array(
        'user_login' => $last_name, // Usar el apellido como nombre de usuario
        'user_email' => $email,
        'user_pass' => $password,
    );

    // Insertar el usuario en la base de datos
    $user_id = wp_insert_user($userdata);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => 'Error creating the user.'));
    }

    // Loguear al usuario después de registrarlo
    $creds = array(
        'user_login'    => $email,
        'user_password' => $password,
        'remember'      => true,
    );
    $user_signon = wp_signon($creds, false);

    if (is_wp_error($user_signon)) {
        wp_send_json_error(array('message' => 'Error logging in the user.'));
    }

    // Responder con éxito; La redirección se hace desde el frente.
    wp_send_json_success(array('message' => 'User registered and logged in successfully.'));
}

add_action('wp_ajax_custom_register_action', 'custom_register_action'); // Para usuarios logueados
add_action('wp_ajax_nopriv_custom_register_action', 'custom_register_action'); // Para usuarios no logueados





// Incluir el archivo necesario para wp_handle_upload()
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

// Guardar los campos personalizados cuando se envíe el comentario
function save_comment_meta_data($comment_id)
{
    if (isset($_POST['rate'])) {
        add_comment_meta($comment_id, 'rate', sanitize_text_field($_POST['rate']));
    }

    if (isset($_FILES['proof']) && !empty($_FILES['proof']['name'])) {
        // Verificar tipo de archivo y tamaño antes de permitir la subida
        $allowed_types = ['image/jpeg', 'image/png', 'application/pdf']; // Agrega los tipos que desees permitir
        $file_type = $_FILES['proof']['type'];
        $file_size = $_FILES['proof']['size'];

        if (in_array($file_type, $allowed_types) && $file_size <= 5 * 1024 * 1024) { // 5MB de tamaño máximo
            // Procesar y subir el archivo
            $file = wp_handle_upload($_FILES['proof'], ['test_form' => false]);

            if (!isset($file['error'])) {
                // Subir la imagen a la biblioteca de medios
                $file_path = $file['file'];
                $file_name = basename($file_path);
                $wp_filetype = wp_check_filetype($file_name, null);

                // Crea el adjunto en la base de datos de WordPress
                $attachment = array(
                    'guid' => $file['url'], // URL de la imagen
                    'post_mime_type' => $wp_filetype['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', $file_name), // Eliminar extensión para el título
                    'post_content' => '',
                    'post_status' => 'inherit', // Establecer como adjunto
                );



                $attachment_id = wp_insert_attachment($attachment, $file_path, 0); //Rescatamos el ID de al imagen recien subida

                if (!is_wp_error($attachment_id)) {

                    // Guardar el ID del adjunto en los metadatos del comentario
                    add_comment_meta($comment_id, 'proof', $attachment_id);
                }
            }
        } else {
            // Manejar error si el archivo no es válido
            add_comment_meta($comment_id, 'proof_error', 'El archivo no es válido o excede el tamaño permitido.');
        }
    }

    if (isset($_POST['anonymous'])) {
        add_comment_meta($comment_id, 'anonymous', 1);
    } else {
        add_comment_meta($comment_id, 'anonymous', 0);
    }
}
add_action('comment_post', 'save_comment_meta_data');



//My account logic
// Cambiar contraseña desde el front
add_action('wp_ajax_save_user_changes', function () {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'No tienes permiso para realizar esta acción.']);
    }

    $user_id = get_current_user_id();
    $password = sanitize_text_field($_POST['password']);

    if (!empty($password)) {
        wp_set_password($password, $user_id);
        wp_send_json_success(['message' => 'Contraseña actualizada correctamente.']);
    } else {
        wp_send_json_error(['message' => 'Por favor, introduce una contraseña válida.']);
    }
});



// Función para manejar la carga de la foto de perfil
function upload_profile_picture()
{
    // Verificar que el usuario esté logueado
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Debes estar logueado para cambiar la foto de perfil.']);
    }

    // Verificar que se haya enviado un archivo
    if (isset($_FILES['profile_picture']) && !empty($_FILES['profile_picture']['name'])) {
        // Procesar el archivo cargado
        $file = $_FILES['profile_picture'];

        // Verificar tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png'];
        $file_type = $file['type'];

        if (in_array($file_type, $allowed_types)) {
            // Subir el archivo y obtener la URL
            $uploaded_file = wp_handle_upload($file, ['test_form' => false]);

            if (!isset($uploaded_file['error'])) {
                // Obtener el ID del archivo adjunto
                $file_path = $uploaded_file['file'];
                $attachment = array(
                    'guid' => $uploaded_file['url'], // URL de la imagen
                    'post_mime_type' => wp_check_filetype($file['name'], null)['type'],
                    'post_title' => sanitize_file_name($file['name']),
                    'post_content' => '',
                    'post_status' => 'inherit', // Establecer como adjunto
                );

                // Insertar el archivo en la base de datos
                $attachment_id = wp_insert_attachment($attachment, $file_path, 0);

                // Si la subida fue exitosa, actualizamos los metadatos del usuario
                if (!is_wp_error($attachment_id)) {
                    $user_id = get_current_user_id();

                    // Verificar si el usuario ya tiene una imagen de perfil
                    $existing_picture = get_user_meta($user_id, 'profile_picture', true);

                    if ($existing_picture) {
                        // Eliminar la imagen anterior (solo si existe)
                        wp_delete_attachment($existing_picture, true); // Eliminar archivo físico y en la base de datos
                    }

                    // Guardar el nuevo ID del adjunto como metadato del usuario
                    update_user_meta($user_id, 'profile_picture', $attachment_id);

                    wp_send_json_success(['message' => 'Foto de perfil actualizada correctamente.']);
                }
            } else {
                wp_send_json_error(['message' => 'Error al subir la foto: ' . $uploaded_file['error']]);
            }
        } else {
            wp_send_json_error(['message' => 'El tipo de archivo no es válido.']);
        }
    } else {
        wp_send_json_error(['message' => 'No se ha seleccionado un archivo.']);
    }
}

add_action('wp_ajax_upload_profile_picture', 'upload_profile_picture');



//Segurity
// Mensaje personalizado para cuando el usuario olvida la contraseña y solicita cambio
function custom_login_script()
{
    // Verificar si estamos en la página de login y si el mensaje contiene "checkemail=confirm"
    if (isset($_GET['checkemail']) && $_GET['checkemail'] === 'confirm') {
?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Verificamos si el mensaje de confirmación existe
                var loginMessage = document.getElementById('login-message');
                if (loginMessage) {
                    // Cambiar el contenido del mensaje
                    loginMessage.innerHTML = '<p><?php echo __('Check your email for the confirmation link, then visit the <a href="/log-in">login page.</a>', 'textdomain'); ?></p>';
                }
            });
        </script>
    <?php
    }
}
add_action('login_footer', 'custom_login_script');

function custom_login_footer_link()
{
    ?>
    <script type="text/javascript">
        document.querySelector('a[href*="wp-login.php"]').setAttribute('href', '<?php echo home_url("/log-in/"); ?>');
    </script>
<?php
}
add_action('login_footer', 'custom_login_footer_link');

//End Segurity



// Mecánica de useful comments controllers save DB
function handle_comment_vote()
{
    if (isset($_POST['comment_id']) && isset($_POST['user_has_voted'])) {

        $comment_id = $_POST['comment_id'];
        $user_has_voted = $_POST['user_has_voted'] === 'true';
        $user_id = get_current_user_id();
        $user_votes = get_comment_meta($comment_id, 'user_votes', true);

        if (!is_array($user_votes)) {
            $user_votes = [];
        }

        if ($user_has_voted) {
            if (!in_array($user_id, $user_votes)) {
                $user_votes[] = $user_id;  // add ID vote
            }
        } else {
            $user_votes = array_diff($user_votes, [$user_id]);
        }
        update_comment_meta($comment_id, 'user_votes', $user_votes);

        // Update Useful Count
        $useful = count($user_votes);
        update_comment_meta($comment_id, 'useful', $useful);

        //send response
        wp_send_json_success('Successful');
    }

    wp_send_json_error();
}

add_action('wp_ajax_toggle_vote', 'handle_comment_vote');
add_action('wp_ajax_nopriv_toggle_vote', 'handle_comment_vote');




//Redireccion depues de hacer log out
function custom_logout_redirect()
{
    wp_redirect(home_url('/log-in/'));
    exit();
}
add_action('wp_logout', 'custom_logout_redirect');


//After Rate
function redirect_to_first_comment_page($location, $comment)
{
    $post_id = $comment->comment_post_ID;
    $post_url = get_permalink($post_id);

    if (!is_user_logged_in()) {

        $location = $post_url . '?comment_posted_anonymous=1#comment-' . $comment->comment_ID;
    } else {
        $location = $post_url . '#comment-' . $comment->comment_ID;
    }

    return $location;
}
add_filter('comment_post_redirect', 'redirect_to_first_comment_page', 10, 2);




//Handle Feedback Form
function handle_form_feedback()
{

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = sanitize_text_field($_POST["name"]);
        $email = sanitize_email($_POST["email"]);
        $comment = sanitize_textarea_field($_POST["comment"]);


        if (empty($name) || empty($email) || empty($comment)) {
            wp_die("Error: Todos los campos son obligatorios.");
        }


        $to = get_option("keinnerross@gmail.com");
        $subject = "New Feedback" . $name;


        $message = "Nombre: $name\n";
        $message .= "Email: $email\n";
        $message .= "Mensaje:\n$comment\n";

        $headers = [
            "From: $name <$email>",
            "Reply-To: $email",
            "Content-Type: text/plain; charset=UTF-8"
        ];

        if (wp_mail($to, $subject, $message, $headers)) {
            wp_redirect(home_url("/"));
            exit;
        } else {
            wp_die("Error: No se pudo enviar el correo.");
        }
    }
}
add_action("admin_post_enviar_formulario", "handle_form_feedback");
add_action("admin_post_nopriv_enviar_formulario", "handle_form_feedback"); // Para usuarios no logueados






//Save Therapist User Function

function save_entry_user() {
    if( isset($_POST['entry_id']) && is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $entry_id = intval($_POST['entry_id']); 

        $favorites = get_user_meta($user_id, 'therapists_saved', true);
        if ( !is_array($favorites) ) {
            $favorites = [];
        }

        if (in_array($entry_id, $favorites)) {
            // Si ya está marcado como favorito, lo eliminamos
            $favorites = array_diff($favorites, [$entry_id]);
        } else {
            // Si no está marcado como favorito, lo agregamos
            $favorites[] = $entry_id;
        }

        update_user_meta($user_id, 'therapists_saved', $favorites);
    }

    exit;
}
add_action('wp_ajax_save_entry_user', 'save_entry_user');
add_action('wp_ajax_nopriv_save_entry_user', 'save_entry_user');














// WP Dashboard Styles
function custom_dashboard_styles()
{
    echo '<style>
        /* Añadir borde redondeado a los paneles del dashboard */
        #wpadminbar, .wrap, .postbox, .postbox .inside, .metabox-prefs {
            border-radius: 12px !important;
        }
    </style>';
}
add_action('admin_head', 'custom_dashboard_styles');
