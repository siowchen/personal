$( function() {
  var currentStep = 1;
  var animating = false;

  var lastStep = $('.step_three').length == 0 ? 2 : 3;
  
  $( '.buttons .continue' ).click( function( evt ) {
    evt.preventDefault();
    forward();
  });

  $( '.button_container .facebook_login' ).click( function( evt ) {
    evt.preventDefault();
    $( '.step_two' ).
      find( 'fieldset' ).hide().end().
      find( '.button_container' ).hide().end().
      find( '.fb_registration_h1' ).show().end().
      find( 'iframe' ).show();
    forward();
  });
  
  $( '.groupon_form' ).submit( function( evt ) {
    if ( currentStep != lastStep ) {
      evt.preventDefault();
      forward();
    }
  });
  
  $('#feature_toggle a').click(function(e) {
    e.preventDefault();
    Effect.toggle('featured', 'slide', { duration: 0.25 });
  });
  
  $( window ).resize( function() {
    resizing = true;
    if ( resizeTimer !== null ) {
      window.clearTimeout( resizeTimer );
    }
    resizeTimer = window.setTimeout( pageRedraw, 200 );
  });
  
  var curr_step = 'step_one';
  getSteps();
  styleSteps( false );
  
  var resizing = false;
  var resizeTimer = null;

  function forward() {
    if ( !animating ) {
      animating = true;
      currentStep++;
      styleSteps( 1000 );

      // in case someone hit enter on one of the first steps
      if ( currentStep == lastStep ) {
        $('#subscription_submit').removeClass('disabled');
      }
    }
  }

  function getSteps() {
    var old_step = ( currentStep == 3 ) ? 'step_one' : null;
    var curr_step = ( currentStep == 1 ) ? 'step_one' : ( currentStep == 2 ) ? 'step_two' : 'step_three';
    var prev_step = ( currentStep == 2 ) ? 'step_one' : ( currentStep == 3 ) ? 'step_two' : null;
    var next_step = ( currentStep == 1 ) ? 'step_two' : ( currentStep == 2 ) ? 'step_three' : null;
    var super_step = ( currentStep == 1 ) ? 'step_three' : null;
    return { old: old_step, curr: curr_step, prev: prev_step, next: next_step, superStep: super_step };
  }

  function pageRedraw() {
    resizing = false;
    styleSteps( 300 );
  }
  
  function styleSteps( animSpeed ) {
    pos = calculatePositions();
    steps = getSteps();
    
    if ( !animSpeed ) {
      $( '.' + steps.old ).css( { left: pos.offLeft + 'px', opacity: 0.3 });
      $( '.' + steps.prev ).css( { left: pos.left + 'px', opacity: 0.3 });
      $( '.' + steps.curr ).css( { left: pos.center + 'px', opacity: 1 });
     //$( '.' + steps.next  ).css( { left: pos.right + 'px', opacity: 0.3 });
      $( '.' + steps.next  ).css( { left: '1700px', opacity: 0.3 });
      $( '.' + steps.superStep  ).css( { left: pos.offRight + 'px', opacity: 0.3 });
      clearAnimateFlag();
    } else {
      $( '.' + steps.old ).animate( { left: pos.offLeft + 'px', opacity: 0.3 }, animSpeed );
      $( '.' + steps.prev ).animate( { left: '-600px', opacity: 0.3 }, animSpeed );
      $( '.' + steps.curr ).animate( { left: pos.center + 'px', opacity: 1 }, { duration: animSpeed, complete: clearAnimateFlag } );
      $( '.' + steps.next  ).animate( { left: pos.right + 'px', opacity: 0.3 }, animSpeed );
      $( '.' + steps.superStep  ).animate( { left: pos.offRight + 'px', opacity: 0.3 }, animSpeed );
    }
  }
  
  function clearAnimateFlag() {
    animating = false;
  }
  
  function calculatePositions() {
    var offset = 20;
    var step_width = $( '.form_step' ).width() / 2;
    var window_width = $( window ).width();
    
    var offLeft = -3 * step_width;
    var leftPos = offset - step_width;
    var centerPos = window_width / 2;
    var rightPos = window_width - offset + step_width;
    var offRight = rightPos + ( 3 * step_width );
    return { offLeft: offLeft, left: leftPos, center: centerPos, right: rightPos, offRight: offRight };
  }
});
