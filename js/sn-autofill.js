//autofill.js
document.addEventListener("DOMContentLoaded", function() {
    // Seu código de preenchimento automático aqui
    // Quando o botão "Preencher Campos Automaticamente" é clicado
    document.getElementById('auto-fill').addEventListener('click', function() {
        // Obter os valores do slug, nome singular e nome plural
        var slug = document.getElementById('cpt-slug').value;
        var singular = document.getElementById('cpt-admin-bar').value;
        var plural = document.getElementById('cpt-menu-name').value;

        // Preencher os campos automaticamente
        document.getElementById('cpt-slug').value = slug;
        document.getElementById('cpt-menu-name').value = plural;
        document.getElementById('cpt-admin-bar').value = singular;
        document.getElementById('cpt-archives').value = 'Item Archives';
        document.getElementById('cpt-attributes').value = 'Item Attributes';
        document.getElementById('cpt-parent-item').value = 'Parent Item:';
        document.getElementById('cpt-all-items').value = 'All Items';
        document.getElementById('cpt-add-new-item').value = 'Add New ' + singular;
        document.getElementById('cpt-add-new').value = 'Add New';
        document.getElementById('cpt-new-item').value = 'New ' + singular;
        document.getElementById('cpt-edit-item').value = 'Edit ' + singular;
        document.getElementById('cpt-update-item').value = 'Update ' + singular;
        document.getElementById('cpt-view-item').value = 'View ' + singular;
        document.getElementById('cpt-view-items').value = 'View ' + plural;
        document.getElementById('cpt-search-items').value = 'Search ' + singular;
        document.getElementById('cpt-not-found').value = 'Not found';
        document.getElementById('cpt-not-found-in-trash').value = 'Not found in Trash';
        document.getElementById('cpt-featured-image').value = 'Featured Image';
        document.getElementById('cpt-set-featured-image').value = 'Set featured image';
        document.getElementById('cpt-remove-featured-image').value = 'Remove featured image';
        document.getElementById('cpt-use-featured-image').value = 'Use as featured image';
        document.getElementById('cpt-insert-into-item').value = 'Insert into item';
        document.getElementById('cpt-uploaded-to-this-item').value = 'Uploaded to this item';
        document.getElementById('cpt-items-list').value = 'Items list';
        document.getElementById('cpt-items-list-navigation').value = 'Items list navigation';
        document.getElementById('cpt-filter-items-list').value = 'Filter items list';
    });
});

document.getElementById('clear-fields').addEventListener('click', function() {
    // Limpar campos, exceto os três primeiros
    var fieldsToClear = [
        'cpt-archives',
        'cpt-attributes',
        'cpt-parent-item',
        'cpt-all-items',
        'cpt-add-new-item',
        'cpt-add-new',
        'cpt-new-item',
        'cpt-edit-item',
        'cpt-update-item',
        'cpt-view-item',
        'cpt-view-items',
        'cpt-search-items',
        'cpt-not-found',
        'cpt-not-found-in-trash',
        'cpt-featured-image',
        'cpt-set-featured-image',
        'cpt-remove-featured-image',
        'cpt-use-featured-image',
        'cpt-insert-into-item',
        'cpt-uploaded-to-this-item',
        'cpt-items-list',
        'cpt-items-list-navigation',
        'cpt-filter-items-list'
    ];

    fieldsToClear.forEach(function(fieldId) {
        document.getElementById(fieldId).value = '';
    });
});

