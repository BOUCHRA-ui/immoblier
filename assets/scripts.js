$(function () {


    if ($('.confirm').length > 0) {

        // Confirmation de suppression
        $('.confirm').on('click', function () {
            return (confirm('Etes vous sûr(e) de vouloir supprimer ce contact ?'));
        })

    }

});