

function ChangeEstate(idStep,idLabel,step,direction){

      $('#base span').removeClass( "active" );
      $('#base label').removeClass( "active" );
      $('#'+idStep).addClass( "active" );
      $('#'+idLabel).addClass( "active" );
      switch(step) {
          case 1:
              $('#labelOne').css('color','#419641');
              $('#stepOne').css('backgroundColor','#419641');
              break;
          case 2:
              if (direction == 'prev'){
                    $('#labelOne').css('color','#333');
                    $('#stepOne').css('backgroundColor','#B39C8C');
                    $('#stepTwo').css('backgroundColor','#888');

              }else{
                    $('#labelTwo').css('color','#419641');
                    $('#stepTwo').css('backgroundColor','#419641');

              }
              break;
          case 3:
              $('#labelTwo').css('color','#333');
              $('#stepTwo').css('backgroundColor','#B39C8C');
              break;

      }


}
