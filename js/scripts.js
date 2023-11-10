//script.js

//Função para exibir os custom post types no formulário de criação
document.addEventListener('DOMContentLoaded', function () {
    // Função para adicionar opções de tipos de post personalizados ao campo "cpt-show-in-menu"
    function addCustomPostTypeOptions() {
        const selectShowInMenu = document.getElementById('cpt-show-in-menu');

        // Limpar opções existentes
        selectShowInMenu.innerHTML = '';

        // Adicionar a opção "Padrão"
        selectShowInMenu.innerHTML = '<option value="true">Padrão</option>';

        // Adicionar os tipos de post personalizados
        Object.keys(customPostTypes).forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = customPostTypes[type];
            selectShowInMenu.appendChild(option);
        });
    }

    // Chame a função para adicionar as opções
    addCustomPostTypeOptions();
});