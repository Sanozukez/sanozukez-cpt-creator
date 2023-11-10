<?php
/**
 * filename sn-register-cpt.php
 * Arquivo responsável por registrar os custom post types no WordPress.
 * 
 * @package sanozukez-cpt-creator
 * @since 0.1
 * @license GPL v3
 * @author: Aureo Duarte Yamanaka Filho [sanozukez]
 * 
 */

/**
 * Obtém o nome do CPT a partir dos comentarios.
 * 
 * @param string $file Caminho do arquivo.
 * @return string|null Nome do CPT ou null se não encontrado.
 * @since 1.0
 */
function obter_nome_cpt_do_arquivo($file)
{   
    // Lê o conteúdo do arquivo
    $content = file_get_contents($file);

    // Encontra a linha que contém o comentário cptName
    preg_match('/cptName\s*=\s*\[([^\s\]]+)\]/', $content, $matches);

    // Retorna o nome do CPT se encontrado, senão retorna null
    return isset($matches[1]) ? $matches[1] : null;
}

/**
 * Registra o CPT automaticamente .
 * 
 * 
 * @since 1.0
 */
function registrar_cpts_automaticamente() {
    // Caminho da pasta onde os arquivos dos CPTs estão localizados
    $cpts_folder_path = plugin_dir_path(__FILE__) . 'custom-post-types/';

    // Lista todos os arquivos na pasta
    $cpt_files = glob($cpts_folder_path . '*.php');

    // Verifica se existem arquivos
    if ($cpt_files) {
        // Loop através de cada arquivo
        foreach ($cpt_files as $cpt_file) {
            // Inclui o arquivo
            include_once $cpt_file;

            // Obtém o nome do CPT do arquivo
            $cpt_name = basename($cpt_file, '.php');

            // Chama a função de registro, se existir
            $registration_function = 'registrar_post_type_' . $cpt_name;

            if (function_exists($registration_function)) {
                call_user_func($registration_function);
            }
        }
    }
}

// Registra os CPTs automaticamente
add_action('init', 'registrar_cpts_automaticamente');
