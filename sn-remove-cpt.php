<?php

/**
 * filename sn-remove-cpt.php
 * Arquivo responsável por registrar os custom post types no WordPress.
 * 
 * @package sanozukez-cpt-creator
 * @since 0.1
 * @license GPL v3
 * @author: Aureo Duarte Yamanaka Filho [sanozukez]
 * 
 */

// Configurar subMenu Remove CPT  do plugin no Wordpress
function config_page_sn_remove_cpt()
{
    // Adiciona o submenu no WordPress
    add_submenu_page(
        'snzkz-cpt-editor',             // parent_slug
        'Remove CPT',                   // page_title
        'Remove CPT',                   // menu_title
        'manage_options',               // capability
        'snzkz-remove-cpt',             // menu_slug
        'settings_page_sn_remove_cpt'   // callback
        // position
    );
}
add_action('admin_menu', 'config_page_sn_remove_cpt');

// Enfileirar scripts
function enqueue_scripts_remove($hook)
{
    // Verifique se a página atual é qualquer página do plugin antes de enfileirar o script
    if (strpos($hook, 'snzkz-remove-cpt') !== false) {
        wp_enqueue_script('scripts', plugin_dir_url(__FILE__) . 'js/remove-scripts.js', array('jquery'), '1.0', true);

        $custom_post_types = get_custom_post_types();
        wp_localize_script('scripts', 'customPostTypes', $custom_post_types);

        // Adicione a criação e inclusão da nonce        
        $cpt_nonce = wp_create_nonce('cpt_nonce');
        $admin_ajax_url = admin_url('admin-ajax.php');
        wp_localize_script('scripts', 'cptFormVars', array('cpt_nonce' => $cpt_nonce, 'ajaxurl' => $admin_ajax_url));
    }
}
add_action('admin_enqueue_scripts', 'enqueue_scripts_remove');

// Página de configurações para remover CPT
function settings_page_sn_remove_cpt()
{
    // Verifica se o formulário foi enviado
    if (isset($_POST['remove-cpt'])) {
        error_log('Formulário para remover CPT enviado.'); // Adiciona um log simples

        // Chama a função para remover o CPT
        remove_cpt_file();
    }

    // Inclua o arquivo HTML do formulário
    include(plugin_dir_path(__FILE__) . 'remove-cpt-form.html');
}


// Função para remover arquivo CPT
function remove_cpt_file()
{
    // Obtém os tipos de post personalizados
    $custom_post_types = get_custom_post_types();

    // Verifica se o formulário foi enviado
    if (isset($_POST['remove-cpt'])) {
        // Obtém o nome do CPT selecionado
        $cpt_name = sanitize_text_field($_POST['cpt-remover']);

        // Verifica se o CPT existe no registro
        if (in_array($cpt_name, $custom_post_types)) {
            // Remove o arquivo do CPT
            $cpt_file_path = plugin_dir_path(__FILE__) . 'custom-post-types/' . $cpt_name . '.php';

            // Verifica se o arquivo existe antes de excluí-lo
            if (file_exists($cpt_file_path)) {
                unlink($cpt_file_path);
                echo '<script>alert("Arquivo do Custom Post Type removido com sucesso! Atualize a página para ver as alterações."); location.reload();</script>';
            } else {
                echo 'Erro: O arquivo do Custom Post Type não foi encontrado.';
            }
        } else {
            echo 'Erro: Custom Post Type não encontrado no registro.';
        }
    }
}