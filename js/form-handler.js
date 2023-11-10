//form-handler.js
// JavaScript para acionar a função quando o botão "Criar" for clicado
// Função para obter os valores do formulário
function getCPTFormData() {
    var formData = new FormData();

    formData.append('action', 'create_cpt_file'); // Adicione a ação para identificar o hook no lado do PHP
    formData.append('cpt-params[name]', document.getElementById('cpt-slug').value);
    formData.append('cpt-params[admin-bar]', document.getElementById('cpt-admin-bar').value);
    formData.append('cpt-params[menu-name]', document.getElementById('cpt-menu-name').value);
    formData.append('cpt-params[archives]', document.getElementById('cpt-archives').value);
    formData.append('cpt-params[attributes]', document.getElementById('cpt-attributes').value);
    formData.append('cpt-params[parent-item]', document.getElementById('cpt-parent-item').value);
    formData.append('cpt-params[all-items]', document.getElementById('cpt-all-items').value);
    formData.append('cpt-params[add-new-item]', document.getElementById('cpt-add-new-item').value);
    formData.append('cpt-params[add-new]', document.getElementById('cpt-add-new').value);
    formData.append('cpt-params[new-item]', document.getElementById('cpt-new-item').value);
    formData.append('cpt-params[edit-item]', document.getElementById('cpt-edit-item').value);
    formData.append('cpt-params[update-item]', document.getElementById('cpt-update-item').value);
    formData.append('cpt-params[view-item]', document.getElementById('cpt-view-item').value);
    formData.append('cpt-params[view-items]', document.getElementById('cpt-view-items').value);
    formData.append('cpt-params[search-items]', document.getElementById('cpt-search-items').value);
    formData.append('cpt-params[not-found]', document.getElementById('cpt-not-found').value);
    formData.append('cpt-params[not-found-in-trash]', document.getElementById('cpt-not-found-in-trash').value);
    formData.append('cpt-params[featured-image]', document.getElementById('cpt-featured-image').value);
    formData.append('cpt-params[set-featured-image]', document.getElementById('cpt-set-featured-image').value);
    formData.append('cpt-params[remove-featured-image]', document.getElementById('cpt-remove-featured-image').value);
    formData.append('cpt-params[use-featured-image]', document.getElementById('cpt-use-featured-image').value);
    formData.append('cpt-params[insert-into-item]', document.getElementById('cpt-insert-into-item').value);
    formData.append('cpt-params[uploaded-to-this-item]', document.getElementById('cpt-uploaded-to-this-item').value);
    formData.append('cpt-params[items-list]', document.getElementById('cpt-items-list').value);
    formData.append('cpt-params[items-list-navigation]', document.getElementById('cpt-items-list-navigation').value);
    formData.append('cpt-params[filter-items-list]', document.getElementById('cpt-filter-items-list').value);
    formData.append('cpt-params[description]', document.getElementById('cpt-description').value);
    formData.append('cpt-params[public]', document.getElementById('cpt-public').value);
    formData.append('cpt-params[exclude-from-search]', document.getElementById('cpt-exclude-from-search').value);
    formData.append('cpt-params[publicly-queryable]', document.getElementById('cpt-publicly-queryable').value);
    formData.append('cpt-params[show-ui]', document.getElementById('cpt-show-ui').value);
    formData.append('cpt-params[show-in-nav-menus]', document.getElementById('cpt-show-in-nav-menus').value);
    formData.append('cpt-params[show-in-menu]', document.getElementById('cpt-show-in-menu').value);
    formData.append('cpt-params[query-var]', document.getElementById('cpt-query-var').value);
    formData.append('cpt-params[rewrite]', document.getElementById('cpt-rewrite').value);
    formData.append('cpt-params[capability-type]', document.getElementById('cpt-capability-type').value);
    formData.append('cpt-params[has-archive]', document.getElementById('cpt-has-archive').value);
    formData.append('cpt-params[hierarchical]', document.getElementById('cpt-hierarchical').value);
    formData.append('cpt-params[menu-position]', document.getElementById('cpt-menu-position').value);
    formData.append('cpt-params[menu-icon]', document.getElementById('cpt-menu-icon').value);


    // Taxonomies (selecione os valores apropriados)
    document.querySelectorAll('input[name="cpt-taxonomies[]"]:checked').forEach(function (checkbox) {
        formData.append('cpt-params[taxonomies][]', checkbox.value);
    });

    // Supports (selecione os valores apropriados)
    document.querySelectorAll('input[name="cpt-supports[]"]:checked').forEach(function (checkbox) {
        formData.append('cpt-params[supports][]', checkbox.value);
    });

    // Show in REST (selecione o valor apropriado)
    formData.append('cpt-params[show-in-rest]', document.getElementById('cpt-show-in-rest').value);

    return formData;
}

document.addEventListener('DOMContentLoaded', function () {
    if (!cptFormVars.scriptLoaded) {
        cptFormVars.scriptLoaded = true;

        // Obtenha a URL de administração do WordPress usando o atributo de dados
        var scriptElement = document.getElementById('my-plugin-script');
        var ajaxUrl = scriptElement.dataset.ajaxUrl;

        // Adicione a criação e inclusão da nonce
        var cptNonce = cptFormVars.cpt_nonce || '';

        // Quando o botão "Criar" for clicado
        document.getElementById('create-cpt').addEventListener('click', function () {
            var formData = getCPTFormData(); // Obtenha os valores dos campos do formulário

            // Exibir a URL de destino
            ajaxUrlField = document.getElementById('ajax-url');
            ajaxUrlField.value = cptFormVars.ajaxurl;

            // Adicione um log para verificar os dados antes do envio
            console.log(formData);

            // Verifique se a variável do nonce está definida
            if (typeof cptFormVars.cpt_nonce !== 'undefined') {
                formData.append('cpt_nonce', cptFormVars.cpt_nonce); // Adicione o nonce aos dados do formulário
            } else {
                alert('Nonce não configurado!');
            }
            // Envie os dados para o servidor como formulário
            createCPTFile(formData);
        });

        // Função para criar o arquivo PHP (código anterior, sem alterações)
        function createCPTFile(formData) {
            var xhr = new XMLHttpRequest();
            var serverUrl = cptFormVars.ajaxurl || ajaxUrlField.value; // Use a URL do campo se `cptFormVars.ajaxurl` não estiver definido
            console.log(serverUrl);
            xhr.open('POST', serverUrl, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // A solicitação foi bem-sucedida, o arquivo PHP foi criado no servidor
                    alert('Arquivo PHP criado com sucesso!');
                    // Ou você pode executar outras ações apropriadas aqui
                } else {
                    // Ocorreu um erro na solicitação (código anterior, sem alterações)
                    console.log(xhr.responseText); // Adicione um log para verificar a resposta do servidor
                }
            };

            xhr.onerror = function () {
                // Ocorreu um erro de rede (código anterior, sem alterações)
                alert('Erro de rede. Verifique sua conexão.');
            };

            xhr.send(formData); // Envie os dados como formulário
        };
    }
});