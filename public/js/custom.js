jQuery(document).ready(function($) {         
   	         
////////////////// SHOW / HIDE TOOLTIP ///////////////////////////
	// au passage de la souris sur le bouton de menu
    $('#hide_menu a').hover( function(){
         $('.menu_tooltip').stop().fadeTo('fast', 1); 
		 $('.menu_tooltip').css('display', 'block');
     },
     function () {
     	$('.menu_tooltip').stop().fadeTo('fast', 0); 
		$('.menu_tooltip').css('display', 'none');
	});
////////////////// END OF SHOW / HIDE TOOLTIP ////////////////////


////////////////// SHOW / HIDE MENU ///////////////////////
	// On recupere la taille du menu
	 	var navHeight = $('#menu_wrap').height();
	 	var hideHeight = navHeight - 120; 

	//HIDING MENU
		// Au click sur le bouton                           
		$('#hide_menu a.menu_visible').live('click',function(){	

				// On ajoute la class hidden
				$('#hide_menu a.menu_visible')
					.removeClass('menu_visible')
					.addClass('menu_hidden');
			   
				// On cache le tooltip     
				$('.menu_tooltip').css('opacity', '0');
				  
				//on cache le menu
				$('#menu_wrap').animate({top: '-='+ hideHeight + 'px'}, "normal");
				// puis on change le texte du tooltip 
				$('.menu_tooltip .tooltip_hide').hide();	   
				$('.menu_tooltip .tooltip_show').show();	
	
				return false;
			});
				  
					
	//SHOWING MENU	
		// Au click sur le bouton
		$('#hide_menu a.menu_hidden').live('click', function(){	
			
			// On ajoute la class visible	
			$('#hide_menu a.menu_hidden')
				.removeClass('menu_hidden')
				.addClass('menu_visible');
		
			// On cache le tooltip     
			$('.menu_tooltip').css('opacity', '0');
			
			//on montre le menu
			$('#menu_wrap').animate({ top: '+='+ hideHeight + 'px'}, 'normal');  
			// puis on change le texte du tooltip 
			$('.menu_tooltip .tooltip_show').hide();
			$('.menu_tooltip .tooltip_hide').show();

			 return false;    
		 });
////////////////// END OF SHOW / HIDE MENU ////////////////


///////////////////// SHOW / HIDE LABEL INPUT ////////////////////////////
	
	if ($('input').val() != ""){
		$('input').load( function() {
			$(this).parent().find('label').fadeOut('fast');
		})
	}
		// lorsqu'on entre dans le champ
		$('input').focus(function(){
			// on fait disparaitre le label
			$(this).parent().find('label').fadeOut('fast');
		})

		// lorsqu'on entre dans le champ
		$('textarea').focus(function(){
			// on fait disparaitre le label
			$(this).parent().find('label').fadeOut('fast');
		})

		// Lorsqu'on sort du champs
		$('input').blur(function(){
			// si le champ est vide 
			if ( $(this).val() == ""){
				// on fait apparaitre le label
				$(this).parent().find('label').fadeIn('fast');
			}
		})
		// Lorsqu'on sort du champs
		$('textarea').blur(function(){
			// si le champ est vide 
			if ( $(this).val() == ""){
				// on fait apparaitre le label
				$(this).parent().find('label').fadeIn('fast');
			}
		})
///////////////////// END OF SHOW / HIDE LABEL INPUT /////////////////////


////////////////// SHOW / HIDE NOTE CLIENT ///////////////////////
	// On recupere la taille des notes
	 	var noteHeight = $('.noteClient').height();

	// on recupere le nombre de note envoyé par php
	// on enleve 1 pour ne pas recupere la note deja afficher
		if (window.nbNote){
			nbNoteCaché = nbNote - 1;
		}
		else {
			nbNoteCaché = 52;
		}
	// on augmente la taille de la liste des notes avec la valeur
	// de la taille d'une note multiplier par le nombre de note a afficher
	 	var newNoteHeight = nbNoteCaché * 52;
	 	var noteHeightplus = noteHeight + newNoteHeight; 	

	//HIDING NOTE CLIENT
		// Au click sur le bouton                           
		$('.ancienneNoteShow').live('click',function(){	
				// On ajoute la class hidden
				$('.ancienneNoteShow')
					.removeClass('ancienneNoteShow')
					.addClass('ancienneNoteHide');

				//on cache le menu
				$('.noteClient').animate({height: noteHeightplus + 'px'}, "normal");
	
				return false;
			});
				  
					
	//SHOWING NOTE CLIENT	
		// Au click sur le bouton
		$('.ancienneNoteHide').live('click', function(){	
			
			// On ajoute la class visible	
			$('.ancienneNoteHide')
				.removeClass('ancienneNoteHide')
				.addClass('ancienneNoteShow');

			//on montre le menu
			$('.noteClient').animate({ height: noteHeight + 'px'}, 'normal');  

			 return false;    
		 });
////////////////// END OF SHOW / HIDE NOTE CLIENT ////////////////


////////////////// FRENCH DATEPICKER /////////////////
		// $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] ); 
////////////////// END OF FRENCH DATEPICKER ///////////////////


////////////////// HIDE FISRT ELEMENT SELECT //////////////////
				//retire le premiere element de la liste de selection
				// $('.select').focus(function(){
				// 	$('option').val(['first']).remove();
				// });
////////////////// HIDE FISRT ELEMENT SELECT END HERE //////////////////


////////////////// SEARCH AJAX SOCIETE //////////////////
		$('#societe').keyup(function(){
			if ($(this).val().length > 2) {
		     	// $('#infoBulle').stop().fadeTo('fast', 1); 
				// $('#infoBulle').css('display', 'block');
				$('#infoBulle').load('/societe/search/val/' + $(this).val());
			};
		});
////////////////// SEARCH AJAX SOCIETE END HERE //////////////////
}); //document.ready function ends here