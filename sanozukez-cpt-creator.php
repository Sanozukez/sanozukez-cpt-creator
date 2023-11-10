<?php

/**
 * filename sanozukez-cpt-creator.php
 * Snzkz CPT Creator
 * 
 * Crie e exclua custom post types.
 * 
 * @package Sanozukez-CPT-Creator
 * @author Aureo Duarte Yamanaka Filho [sanozukez]
 * @license GPL-v3.0
 * @version 1.0
 * 
 * @wordpress-plugin
 * Plugin Name: Sanozukez CPT Creator
 * Plugin URI: *
 * Description: Crie e exclua Custom Post Types facilmente.
 * Version: 1.0.0
 * Requires at least: *
 * Requires PHP: *
 * Author: Aureo Duarte Yamanaka Filho
 * Author URI: https://yamanakafilho.com.br
 * Text Domain: snzkz-cpt-editor
 * License: GPL v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Update URI: *
 */

// Configurar Menu top-level do plugin no Wordpress
function config_page_sanozukez_cpt_creator()
{
    // Adiciona o menu no WordPress
    add_menu_page(
        'Custom Post Type Creator', // page_title
        'Create CPT ',              // menu_title
        'manage_options',           // capability
        'snzkz-cpt-editor',         // menu_slug
        'settings_page',             // callback
        plugin_dir_url(__FILE__) . 'assets/sIcon.svg', // menu_icon_url
        // position
    );
}
add_action('admin_menu', 'config_page_sanozukez_cpt_creator');

function enqueue_custom_styles() {
    // Use a função wp_enqueue_style para adicionar seu arquivo CSS
    wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'css/sn-snzkz-cpt-styles.css');
}

// Adicione os estilos ao carregar os scripts do WordPress
add_action('admin_enqueue_scripts', 'enqueue_custom_styles');

// Enfileirar scripts
function enqueue_scripts($hook)
{
    // Verifique se a página atual é qualquer página do plugin antes de enfileirar o script
    if (strpos($hook, 'snzkz-cpt-editor') !== false) {
        wp_enqueue_script('custom-autofill', plugin_dir_url(__FILE__) . 'js/sn-autofill.js', array('jquery'), '1.0', true);
        wp_enqueue_script('form-handler', plugin_dir_url(__FILE__) . 'js/form-handler.js', array('jquery'), '1.0', true);
        wp_enqueue_script('scripts', plugin_dir_url(__FILE__) . 'js/scripts.js', array('jquery'), '1.0', true);

        $custom_post_types = get_custom_post_types();
        wp_localize_script('scripts', 'customPostTypes', $custom_post_types);

        // Adicione a criação e inclusão da nonce        
        $cpt_nonce = wp_create_nonce('cpt_nonce');
        $admin_ajax_url = admin_url('admin-ajax.php');
        wp_localize_script('form-handler', 'cptFormVars', array('cpt_nonce' => wp_create_nonce('cpt_nonce'), 'ajaxurl' => $admin_ajax_url));
    }
}
add_action('admin_enqueue_scripts', 'enqueue_scripts');

// Página de configuração do plugin
function settings_page()
{
    // Inclua o arquivo HTML do formulário
    include(plugin_dir_path(__FILE__) . 'cpt-form.html');
}

// Obter os post types existentes
function get_custom_post_types()
{
    $args = array(
        'public'   => true,
        '_builtin' => false
    );

    $output = 'names'; // 'names' or 'objects' (default: 'names')
    $operator = 'and'; // 'and' or 'or' (default: 'and')

    $custom_post_types = get_post_types($args, $output, $operator);

    return $custom_post_types;
}

function create_cpt_file()
{
    // Obtém o nonce recebido na solicitação AJAX
    $received_nonce = isset($_POST['cpt_nonce']) ? sanitize_text_field($_POST['cpt_nonce']) : '';

    // Validação do nonce
    if (!wp_verify_nonce($received_nonce, 'cpt_nonce')) {
        // O nonce não é válido, trate o erro
        echo 'Erro de verificação de segurança.';
        exit;
    }

    // Obtém os parâmetros do formulário do objeto FormData
    $cpt_params = $_POST['cpt-params'];

    if (isset($cpt_params)) {
        // Constrói o código PHP com base nos valores do formulário
        // Constrói os comentários do arquivo PHP
        $cpt_code = "<?php\n";
        $cpt_code .= "/**\n";
        $cpt_code .= " * @package sanozukez-cpt-creator\n";
        $cpt_code .= " * @since 0.1\n";
        $cpt_code .= " * @license GPL v3\n";
        $cpt_code .= " * @author: Aureo Duarte Yamanaka Filho [sanozukez]\n";
        $cpt_code .= " * cptName =[" . $cpt_params['name'] . "]\n";
        $cpt_code .= " */\n\n";  // Duas quebras de linha para separação
        $cpt_code .= "function registrar_post_type_" . $cpt_params['name'] . "() {\n";

        // Constrói o código para o array de labels
        $cpt_code .= "    \$labels = array(\n";
        $cpt_code .= "        'name'               => '" . $cpt_params['menu-name'] . "',\n";
        $cpt_code .= "        'singular_name'      => '" . $cpt_params['admin-bar'] . "',\n";
        $cpt_code .= "        'menu_name'          => '" . $cpt_params['menu-name'] . "',\n";
        $cpt_code .= "        'name_admin_bar'     => '" . $cpt_params['admin-bar'] . "',\n";
        $cpt_code .= "        'add_new'            => 'Adicionar Novo',\n";
        $cpt_code .= "        'add_new_item'       => 'Adicionar Novo " . $cpt_params['admin-bar'] . "',\n";
        $cpt_code .= "        'new_item'           => 'Novo " . $cpt_params['admin-bar'] . "',\n";
        $cpt_code .= "        'edit_item'          => 'Editar " . $cpt_params['admin-bar'] . "',\n";
        $cpt_code .= "        'view_item'          => 'Ver " . $cpt_params['admin-bar'] . "',\n";
        $cpt_code .= "        'all_items'          => 'Todos os " . $cpt_params['menu-name'] . "',\n";
        $cpt_code .= "        'search_items'       => 'Buscar " . $cpt_params['menu-name'] . "',\n";
        $cpt_code .= "        'parent_item_colon'  => '" . $cpt_params['admin-bar'] . " Pai:',\n";
        $cpt_code .= "        'not_found'          => 'Nenhum " . $cpt_params['admin-bar'] . " encontrado.',\n";
        $cpt_code .= "        'not_found_in_trash' => 'Nenhum " . $cpt_params['admin-bar'] . " encontrado na lixeira.',\n";
        $cpt_code .= "    );\n\n";

        // Constrói o código o para array args
        $cpt_code .= "    \$args = array(\n";
        $cpt_code .= "        'labels'             => \$labels,\n";
        $cpt_code .= "        'description'        => 'Custom Post Type para " . $cpt_params['menu-name'] . "',\n";
        $cpt_code .= "        'public'             => " . ($cpt_params['public'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'exclude_from_search'=> " . ($cpt_params['exclude-from-search'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'publicly_queryable' => " . ($cpt_params['publicly-queryable'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'show_ui'            => " . ($cpt_params['show-ui'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'show_in_nav_menus'  => " . ($cpt_params['show-in-nav-menus'] === 'true' ? 'true' : 'false') . ",\n";

        // Verifica se 'show-in-menu' é 'true' ou um nome de post type existente
        if ($cpt_params['show-in-menu'] === 'true') {
            $cpt_code .= "        'show_in_menu'       => true,\n";
        } elseif (post_type_exists($cpt_params['show-in-menu'])) {
            $cpt_code .= "        'show_in_menu'       => 'edit.php?post_type=" . $cpt_params['show-in-menu'] . "',\n";
        } else {
            // Adiciona um valor padrão ou manipula conforme necessário
            $cpt_code .= "        'show_in_menu'       => true,\n";
        }

        // Continua o código o para array args
        $cpt_code .= "        'query_var'          => " . ($cpt_params['query-var'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'rewrite'            => " . ($cpt_params['rewrite'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'capability_type'    => '" . $cpt_params['capability-type'] . "',\n";
        $cpt_code .= "        'has_archive'        => " . ($cpt_params['has-archive'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'hierarchical'       => " . ($cpt_params['hierarchical'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "        'menu_position'      => " . $cpt_params['menu-position'] . ",\n";

        // Adiciona as taxonomias
        $cpt_code .= "        'taxonomies'         => array('" . implode("', '", $cpt_params['taxonomies']) . "'),\n";

        // Adiciona os suportes
        $cpt_code .= "        'supports'           => array('" . implode("', '", $cpt_params['supports']) . "'),\n";

        // Continua o código o para array args
        $cpt_code .= "        'show_in_rest'       => " . ($cpt_params['show-in-rest'] === 'true' ? 'true' : 'false') . ",\n";
        $cpt_code .= "    );\n";
        // Finalizando código de registro de cpt's
        $cpt_code .= "    register_post_type('" . $cpt_params['name'] . "', \$args);\n";
        $cpt_code .= "}\n";
        $cpt_code .= "add_action('init', 'registrar_post_type_" . $cpt_params['name'] . "');\n\n";

        // Salve o código no arquivo na pasta "custom-post-types"
        $cpt_file_path = plugin_dir_path(__FILE__) . 'custom-post-types/' . $cpt_params['name'] . '.php';
        file_put_contents($cpt_file_path, $cpt_code);

        echo 'Arquivo PHP criado com sucesso! Seu novo tipo de post foi criado.';
    } else {
        echo 'Erro: os dados do formulário não foram recebidos corretamente. Por favor, entre em contato com o desenvolvedor.';
    }

    die(); // Encerre a execução após a resposta AJAX
}

add_action('wp_ajax_create_cpt_file', 'create_cpt_file'); // Registre a função para usuários autenticados

include_once(plugin_dir_path(__FILE__) . 'sn-register-cpt.php');
include_once(plugin_dir_path(__FILE__) . 'sn-remove-cpt.php');
