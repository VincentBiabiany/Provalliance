

/**
 *
 * Temps Partiel
 *
 */
function tempsPartiel() {
  var $tempsTotal = 0;
  // Contrôle sur les heures
  $(".tempsHeure").prop("type", "number");
  $('.tempsHeure').blur(function(){
    if (parseInt($(this).val()) > 9 )
      $(this).val(9)
    if (parseInt($(this).val()) < 0)
      $(this).val(0)

    $tempsTotal = 0
    $('.tempsHeure').each(function( index ) {
     var $value = parseInt($(this).val());

      if (isNaN($value))
        $value = 0;
      $tempsTotal += $value;
    });

    //console.log('Value = ' + $tempsTotal);
    $('.total').val($tempsTotal);
  });
}

/**
 *
 * Controle du champs date
 *
 */
jQuery.validator.addMethod("greaterThan",
function(value, element, params) {

  dateFin = getDateFromParent(element);
  dateDebut = getDateFromParent(params)

  return  dateFin >= dateDebut;


},'Doit être plus grande que la date de début');


/*
 *
 * Controle du champs date
 *
 */
jQuery.validator.addMethod("validateDate", function(value, element) {
  var dates = getArrayDateFromParent(element);

  var m = parseInt( dates[1], 10);
  var d = parseInt( dates[0], 10);
  var y = parseInt( dates[2], 10);

  var date = new Date(y, m - 1, d);

  return (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d);
}, "Date incorrecte");


/**
 *
 * Retourne un tableau des champs dates
 *
 */
function getArrayDateFromParent(element){
  dates = new Array();
  $(element).parent().find('select').each(function(){
     dates.push($(this).val());
  });
  return dates;
}


/**
 *
 * Retourne une date
 *
 */
function getDateFromParent(element){
  dates = new Array();
  $(element).parent().find('select').each(function(){
     dates.push($(this).val());
  });
  var m = parseInt( dates[1], 10);
  var d = parseInt( dates[0], 10);
  var y = parseInt( dates[2], 10);

  var date = new Date(y, m - 1, d);

  return date;
}

/**
 *
 * Controle 2 champs date
 *
 */
function controlChangeDate($date1, $date2) {
  $($date1).focusout(function(){
      $($date1 +'_month').valid();
  		$($date2 + '_month').valid();
  })
  $($date2).focusout(function(){
      $($date2 +'_month').valid();
  })
}

/**
 *
 * Met la valeur du champs en majuscule
 *
 */
function uppercaseField($champs){
  $($champs).bind('keyup', function (e) {
      if (e.which >= 97 && e.which <= 122) {
          var newKey = e.which - 32;
          // I have tried setting those
          e.keyCode = newKey;
          e.charCode = newKey;
      }
      $($champs).val(($($champs).val()).toUpperCase());
  });

  $($champs).focusout(function () {
    $($champs).val (function () {
        return this.value.toUpperCase();
    })
  });
}
