//Função para exibir os custom post types no formulário de remoção
document.addEventListener('DOMContentLoaded', function () {
    // Função para adicionar opções de tipos de post personalizados ao campo "cpt-remover"
    function addCustomPostTypeOptionsToRemove() {
        const selectShowInMenu = document.getElementById('cpt-remover');

        // Limpar opções existentes
        selectShowInMenu.innerHTML = '';

        // Adicionar a opção padrão
        const defaultOption = document.createElement('option');
        defaultOption.value = '';  // Valor vazio
        defaultOption.textContent = 'Selecione um Tipo';  // Texto informativo
        selectShowInMenu.appendChild(defaultOption);

        // Adicionar os tipos de post personalizados
        Object.keys(customPostTypes).forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = customPostTypes[type];
            selectShowInMenu.appendChild(option);
        });
    }

    // Chame a função para adicionar as opções
    addCustomPostTypeOptionsToRemove();
});