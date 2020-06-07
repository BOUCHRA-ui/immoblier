// pour confirmer la suppression d'un article

$(function(){  //fonction courte du document ready
//si j'ai des eleements de class 'confirm
    if($('.confirm').length > 0){

            //j'ajoute l'evenement click
        $('.confirm').on('click',function(){
                return(confirm('Etes vous sûr(e) de vouloir supprimer ce jeu?'));
        });


    }


});
