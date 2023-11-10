//preview-cpt.js
// JavaScript para acionar a função quando o botão "Preview" for clicado
document.getElementById('cpt-preview-code').addEventListener('click', function () {
    var formData = getCPTFormData(); // Obtenha os valores dos campos do formulário

    // Exiba os dados capturados em uma div ou modal
    var previewResult = document.getElementById('preview-code-result');
    previewResult.innerHTML = '<pre>' + formatFormData(formData) + '</pre>';
});

// Função para obter os valores do formulário
function getCPTFormData() {
    var formData = new FormData(document.getElementById('pt-form'));

    return formData;
}

// Função para formatar os dados do FormData para exibição
function formatFormData(formData) {
    var formattedData = {};
    formData.forEach(function (value, key) {
        formattedData[key] = value;
    });

    return JSON.stringify({ 'cpt-params': formattedData }, null, 2);
}

// Limpar a div quando o botão "Clear" for clicado
document.getElementById('cpt-clear-code').addEventListener('click', function () {
    var previewResult = document.getElementById('preview-code-result');
    previewResult.innerHTML = ''; // Limpar o conteúdo da div
});