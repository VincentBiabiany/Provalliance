    // Function sameDemande
		// Paramètres : Nom Demande (eg: Demande d'acompte, Demande d'embauche)
    // Description : Active ou Désactive la fonctionnalité EXPORT MULTIPLE" si les demandes sélectionnées ne sont pas du même type
		// Return : boolean
    function sameDemande(types){
			 result = true;
			for(i=0;i < types.length-1; i++){
					if(types[i] == types[i+1]){
						result = true;
					}else{
						result = false;
					}
		  }
			return result;
    }



		// Trigger Export
		// Description : Export multiple des demandes
				$('#export').on( 'click', function () {
					demandes = [];
					types =[];
					i=0;
					$('tr.selected').each(function(i, obj) {
								 demandes[i]= dt.row(this).data()['id'];
								 types[i] =  dt.row(this).data()['type'];

						});

						//On vérifie que les demandes soient du même type
						if (sameDemande(types)){
								//Injection des id des demandes pour exportXls Multiple
								$('input#form_idDemandes').val(demandes);
								$('#exportMultiple').submit();
						}else{
							$(".flashConfirmation").html('');
							$(".flashConfirmation").css('color','red');
							$(".flashConfirmation").append('Export impossible !<br/> Les demandes sélectionnées ne sont pas du même types.');
							$("#myModal").modal();
					 	 $("#myModal").css('display','flex');
						}
			});


	    // Trigger Sélection
			//Description : Sélection de toutes les demandes
					$('#allselect').on( 'click', function () {
						$('#demande tbody tr').each(function(i, obj) {
								if ($(this).is('.selected')){}else{
									$(this).addClass('selected');
									 }
							});
							$('#nbSelect .counter').text(dt.rows('.selected').data().length+' ');
							if (  $('tr.selected').length >0){
										if (  $('tr.selected').length == 1){
												$('#nbSelect .textSelect').text('élément sélectionné');
										}else{
												$('#nbSelect .textSelect').text('éléments sélectionnés');
										}
									}
				}
			);

			// Trigger Désélection
			// Description : Déselection des demandes au préalablement sélectionnées
			 $('#deselect').on( 'click', function () {
					$('tr.selected').removeClass('selected');
					$('#selectionMultiple div').css('display','none');
			 });
