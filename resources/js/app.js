import './bootstrap';

//Importando o jQuery
import $ from 'jquery';

//Importando a biblioteca do editor Summernote
import 'summernote/dist/summernote-lite';
import 'summernote/dist/summernote-lite.css';

//Expor o jQuery no escopo global e torná-lo acessível globalmente
window.$ = window.jQuery = $

//Função para carregar o editor
$(function () {
	$('#summernote').summernote({
        height: 150
    });
});

//Alert p/ confirmar a exclusão
window.confirmDelete = function (id) {
    Swal.fire({
        title: "Tem certeza?",
        text: "Essa ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir!", 
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}