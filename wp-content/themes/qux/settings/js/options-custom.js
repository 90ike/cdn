/**
 * Custom scripts needed for the colorpicker, image button selectors,
 * and navigation tabs.
 */
;(function( $, window, document, undefined ) {
    

  var OF   = OF || {};

  OF.funcs = {};

  OF.vars  = {
    onloaded: false,
    $body: $('body'),
    $window: $(window),
    $document: $(document),
    is_rtl: $('body').hasClass('rtl'),
    code_themes: [],
  };
    
    
    OF.helper = {

    //
    // Generate UID
    //
    uid: function( prefix ) {
      return ( prefix || '' ) + Math.random().toString(36).substr(2, 9);
    },

    // Quote regular expression characters
    //
    preg_quote: function( str ) {
      return (str+'').replace(/(\[|\-|\])/g, "\\$1");
    },

    //
    // Reneme input names
    //
    name_nested_replace: function( $selector, field_id ) {

      var checks = [];
      var regex  = new RegExp('('+ OF.helper.preg_quote(field_id) +')\\[(\\d+)\\]', 'g');

      $selector.find(':radio').each(function() {
        if( this.checked || this.orginal_checked ) {
          this.orginal_checked = true;
        }
      });

      $selector.each( function( index ) {
        $(this).find(':input').each(function() {
          this.name = this.name.replace(regex, field_id +'['+ index +']');
          if( this.orginal_checked ) {
            this.checked = true;
          }
        });
      });

    },

    //
    // Debounce
    //
    debounce: function( callback, threshold, immediate ) {
      var timeout;
      return function() {
        var context = this, args = arguments;
        var later = function() {
          timeout = null;
          if( !immediate ) {
            callback.apply(context, args);
          }
        };
        var callNow = ( immediate && !timeout );
        clearTimeout( timeout );
        timeout = setTimeout( later, threshold );
        if( callNow ) {
          callback.apply(context, args);
        }
      };
    },

    //
    // Get a cookie
    //
    get_cookie: function( name ) {

      var e, b, cookie = document.cookie, p = name + '=';

      if( ! cookie ) {
        return;
      }

      b = cookie.indexOf( '; ' + p );

      if( b === -1 ) {
        b = cookie.indexOf(p);

        if( b !== 0 ) {
          return null;
        }
      } else {
        b += 2;
      }

      e = cookie.indexOf( ';', b );

      if( e === -1 ) {
        e = cookie.length;
      }

      return decodeURIComponent( cookie.substring( b + p.length, e ) );

    },

    //
    // Set a cookie
    //
    set_cookie: function( name, value, expires, path, domain, secure ) {

      var d = new Date();

      if( typeof( expires ) === 'object' && expires.toGMTString ) {
        expires = expires.toGMTString();
      } else if( parseInt( expires, 10 ) ) {
        d.setTime( d.getTime() + ( parseInt( expires, 10 ) * 1000 ) );
        expires = d.toGMTString();
      } else {
        expires = '';
      }

      document.cookie = name + '=' + encodeURIComponent( value ) +
        ( expires ? '; expires=' + expires : '' ) +
        ( path    ? '; path=' + path       : '' ) +
        ( domain  ? '; domain=' + domain   : '' ) +
        ( secure  ? '; secure'             : '' );

    },

    //
    // Remove a cookie
    //
    remove_cookie: function( name, path, domain, secure ) {
      OF.helper.set_cookie( name, '', -1000, path, domain, secure );
    },

  };
    
    $.fn.csf_clone = function() {

    var base   = $.fn.clone.apply(this, arguments),
        clone  = this.find('select').add(this.filter('select')),
        cloned = base.find('select').add(base.filter('select'));

    for( var i = 0; i < clone.length; ++i ) {
      for( var j = 0; j < clone[i].options.length; ++j ) {

        if( clone[i].options[j].selected === true ) {
          cloned[i].options[j].selected = true;
        }

      }
    }

    this.find(':radio').each( function() {
      this.orginal_checked = this.checked;
    });

    return base;

  };
  
  $.fn.csf_customizer_refresh = function() {
    return this.each( function() {

      var $this    = $(this),
          $complex = $this.closest('.csf-customize-complex');

      if( $complex.length ) {

        var $input  = $complex.find(':input'),
            $unique = $complex.data('unique-id'),
            $option = $complex.data('option-id'),
            obj     = $input.serializeObjectOF(),
            data    = ( !$.isEmptyObject(obj) ) ? obj[$unique][$option] : '',
            control = wp.customize.control($unique +'['+ $option +']');

        // clear the value to force refresh.
        control.setting._value = null;

        control.setting.set( data );

      } else {

        $this.find(':input').first().trigger('change');

      }

      $(document).trigger('csf-customizer-refresh', $this);

    });
  };
  
  $.fn.csf_customizer_listen = function( options ) {

    var settings = $.extend({
      closest: false,
    }, options );

    return this.each( function() {

      if( window.wp.customize === undefined ) { return; }

      var $this     = ( settings.closest ) ? $(this).closest('.csf-customize-complex') : $(this),
          $input    = $this.find(':input'),
          unique_id = $this.data('unique-id'),
          option_id = $this.data('option-id');

      if( unique_id === undefined ) { return; }

      $input.on('change keyup', OF.helper.debounce( function() {

        var obj = $this.find(':input').serializeObjectOF();

        if( !$.isEmptyObject(obj) && obj[unique_id] ) {

          window.wp.customize.control( unique_id +'['+ option_id +']' ).setting.set( obj[unique_id][option_id] );

        }

      }, 250 ) );

    });
  };
  

  $.fn.csf_field_group = function() {
    return this.each( function() {

      var $this     = $(this),
          $fieldset = $this.children().children('.controls'),
          $group    = $fieldset.length ? $fieldset : $this,
          $wrapper  = $group.children('.csf-cloneable-wrapper'),
          $hidden   = $group.children('.csf-cloneable-hidden'),
          $max      = $group.children('.csf-cloneable-max'),
          $min      = $group.children('.csf-cloneable-min'),
          field_id  = $wrapper.data('field-id'),
          unique_id = $wrapper.data('unique-id'),
          is_number = Boolean( Number( $wrapper.data('title-number') ) ),
          max       = parseInt( $wrapper.data('max') ),
          min       = parseInt( $wrapper.data('min') );

      // clear accordion arrows if multi-instance
      if( $wrapper.hasClass('ui-accordion') ) {
        $wrapper.find('.ui-accordion-header-icon').remove();
      }

      var update_title_numbers = function( $selector ) {
        $selector.find('.csf-cloneable-title-number').each( function( index ) {
          $(this).html( ( $(this).closest('.csf-cloneable-item').index()+1 ) + '.' );
        });
      };

      $wrapper.accordion({
        header: '> .csf-cloneable-item > .csf-cloneable-title',
        collapsible : true,
        active: false,
        animate: false,
        heightStyle: 'content',
        icons: {
          'header': 'csf-cloneable-header-icon fa fa-angle-right',
          'activeHeader': 'csf-cloneable-header-icon fa fa-angle-down'
        },
        activate: function( event, ui ) {

          var $panel  = ui.newPanel;
          var $header = ui.newHeader;

          if( $panel.length && !$panel.data( 'opened' ) ) {

            var $fields = $panel.children();
            var $first  = $fields.first().find('select');//$fields.first().find('option:selected').first();
            var $title  = $header.find('.csf-cloneable-value');
            
            $first.on('change', function( event ) {
              //$title.text($first.val());
              $title.text($first.children('option:selected').text());
            });

            //$panel.csf_reload_script();
            $panel.data( 'opened', true );
            $panel.data( 'retry', false );

          } else if( $panel.data( 'retry' ) ) {

            //$panel.csf_reload_script_retry();
            $panel.data( 'retry', false );

          }

        }
      });

      $wrapper.sortable({
        axis: 'y',
        handle: '.csf-cloneable-title,.csf-cloneable-sort',
        helper: 'original',
        cursor: 'move',
        placeholder: 'widget-placeholder',
        start: function( event, ui ) {

          $wrapper.accordion({ active:false });
          $wrapper.sortable('refreshPositions');
          ui.item.children('.csf-cloneable-content').data('retry', true);

        },
        update: function( event, ui ) {

          OF.helper.name_nested_replace( $wrapper.children('.csf-cloneable-item'), field_id );
          $wrapper.csf_customizer_refresh();

          if( is_number ) {
            update_title_numbers($wrapper);
          }

        },
      });

      //$group.children().children('.csf-cloneable-add').on('click', function( e ) {
      $('.csf-cloneable-add').on('click', function( e ) {
        e.preventDefault();

        var count = $wrapper.children('.csf-cloneable-item').length;

        $min.hide();

        if( max && (count+1) > max ) {
          $max.show();
          return;
        }

        var new_field_id = unique_id + field_id + '['+ count +']';

        var $cloned_item = $hidden.csf_clone(true);

        $cloned_item.removeClass('csf-cloneable-hidden');

        $cloned_item.find(':input').each( function() {
          this.name = new_field_id + this.name.replace( ( this.name.startsWith('_nonce') ? '_nonce' : unique_id ), '');
        });

        $cloned_item.find('.csf-data-wrapper').each( function(){
          $(this).attr('data-unique-id', new_field_id );
        });

        $wrapper.append($cloned_item);
        $wrapper.accordion('refresh');
        $wrapper.accordion({active: count});
        $wrapper.csf_customizer_refresh();
        $wrapper.csf_customizer_listen({closest: true});

        if( is_number ) {
          update_title_numbers($wrapper);
        }

      });

      var event_clone = function( e ) {

        e.preventDefault();

        var count = $wrapper.children('.csf-cloneable-item').length;

        $min.hide();

        if( max && (count+1) > max ) {
          $max.show();
          return;
        }

        var $this           = $(this),
            $parent         = $this.parent().parent(),
            $cloned_helper  = $parent.children('.csf-cloneable-helper').csf_clone(true),
            $cloned_title   = $parent.children('.csf-cloneable-title').csf_clone(),
            $cloned_content = $parent.children('.csf-cloneable-content').csf_clone(),
            cloned_regex    = new RegExp('('+ OF.helper.preg_quote(field_id) +')\\[(\\d+)\\]', 'g');

        $cloned_content.find('.csf-data-wrapper').each( function(){
          var $this = $(this);
          $this.attr('data-unique-id', $this.attr('data-unique-id').replace(cloned_regex, field_id +'['+ ($parent.index()+1) +']') );
        });

        var $cloned = $('<div class="csf-cloneable-item" />');

        $cloned.append($cloned_helper);
        $cloned.append($cloned_title);
        $cloned.append($cloned_content);

        $wrapper.children().eq($parent.index()).after($cloned);

        OF.helper.name_nested_replace( $wrapper.children('.csf-cloneable-item'), field_id );

        $wrapper.accordion('refresh');
        $wrapper.csf_customizer_refresh();
        $wrapper.csf_customizer_listen({closest: true});

        if( is_number ) {
          update_title_numbers($wrapper);
        }

      };

      $wrapper.children('.csf-cloneable-item').children('.csf-cloneable-helper').on('click', '.csf-cloneable-clone', event_clone);
      $group.children('.csf-cloneable-hidden').children('.csf-cloneable-helper').on('click', '.csf-cloneable-clone', event_clone);

      var event_remove = function( e ) {

        e.preventDefault();

        var count = $wrapper.children('.csf-cloneable-item').length;

        $max.hide();
        $min.hide();

        if( min && (count-1) < min ) {
          $min.show();
          return;
        }

        $(this).closest('.csf-cloneable-item').remove();

        OF.helper.name_nested_replace( $wrapper.children('.csf-cloneable-item'), field_id );

        $wrapper.csf_customizer_refresh();

        if( is_number ) {
          update_title_numbers($wrapper);
        }

      };

      $wrapper.children('.csf-cloneable-item').children('.csf-cloneable-helper').on('click', '.csf-cloneable-remove', event_remove);
      $group.children('.csf-cloneable-hidden').children('.csf-cloneable-helper').on('click', '.csf-cloneable-remove', event_remove);

    });
  };
  
  
  $(document).ready(function($) {

	// Loads the color pickers
	$('.of-color').wpColorPicker();

	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});

	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	// Loads tabbed sections if they exist
	if ( $('.nav-tab-wrapper').length > 0 ) {
		options_framework_tabs();
	}
	
	if($('.section-fields').length > 0){
	    $('.section-fields').csf_field_group();
	}

	function options_framework_tabs() {

		var $group = $('.group'),
			$navtabs = $('.nav-tab-wrapper a'),
			active_tab = '';

		// Hides all the .group sections to start
		$group.hide();

		// Find if a selected tab is saved in localStorage
		if ( typeof(localStorage) != 'undefined' ) {
			active_tab = localStorage.getItem('active_tab');
		}

		// If active tab is saved and exists, load it's .group
		if ( active_tab != '' && $(active_tab).length ) {
			$(active_tab).fadeIn();
			$(active_tab + '-tab').addClass('nav-tab-active');
		} else {
			$('.group:first').fadeIn();
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		// Bind tabs clicks
		$navtabs.click(function(e) {

			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass('nav-tab-active');

			$(this).addClass('nav-tab-active').blur();

			if (typeof(localStorage) != 'undefined' ) {
				localStorage.setItem('active_tab', $(this).attr('href') );
			}

			var selected = $(this).attr('href');

			$group.hide();
			$(selected).fadeIn();

		});
		
	}
	
	
	/*$('.of-chosen').chosen({
	     no_results_text: "没有找到结果！",
	     allow_single_deselect: true,
	     disable_search_threshold: 15,
	     width: '100%'
	});*/
	
	/*$(".of-chosen").select2({
	    tags: true,
	    width: '100%',
	    multiple: true
	});*/
	/*$(".of-chosen").select2({
        triggerChange: true,
        allowClear: true,
        width: "100%"
    });
    
    default_params = {};
    default_params.bindOrder = 'sortableStop';
    default_params.sortableOptions = {placeholder: 'ui-state-highlight'};
    
    $(".of-chosen").select2Sortable(default_params);
    
    $(".of-chosen").on("change", function() {$(".of-chosen").select2SortableOrder();});*/
    
    
    $('#optionsframework').find( '.of-chosen' ).each(
        function() {
            var default_params = {
                width: '100%',
                triggerChange: true,
                allowClear: true
            };

            $( this ).select2( default_params );

            if ( $( this ).hasClass( 'select2-sortable' ) ) {
                default_params = {};
                default_params.bindOrder = 'sortableStop';
                default_params.sortableOptions = {placeholder: 'ui-state-highlight'};
                $( this ).select2Sortable( default_params );
            }

            $( this ).on(
                "change", function() {
                    $( this ).select2SortableOrder();
                }
            );
        }
    );

	
	jQuery('#notice_cat_s').click(function() {
	  	jQuery('#section-site_notice_cat').fadeToggle(400);
	});

	if (jQuery('#notice_cat_s:checked').val() !== undefined) {
		jQuery('#section-site_notice_cat').show();
	}
	
	jQuery('#gravatar_bom').click(function() {
	  	jQuery('#section-gravatar_url').fadeToggle(400);
	});

	if (jQuery('#gravatar_bom:checked').val() !== undefined) {
		jQuery('#section-gravatar_url').show();
	}
		
	$('.'+$('#alipay_option').children('option:selected').val()).show();
	if($('#wxpay_option').children('option:selected').val() == 'xhpay'){
		$('.xhwxpay').show();
	}else{
		$('.'+$('#wxpay_option').children('option:selected').val()).show();	
	}
		
	$('#alipay_option').change(function(){
		var p1 = $(this).children('option:selected').val()
		if(p1 == 'alipay'){
			$('.alipay').show();
		}else{
			$('.alipay').hide();
		}
			
		if(p1 == 'f2fpay'){
			$('.f2fpay').show();
		}else{
			$('.f2fpay').hide();
		}
			
		if(p1 == 'alipay_jk'){
			$('.alipay_jk').show();
		}else{
			$('.alipay_jk').hide();
		}
			
		if(p1 == 'codepay'){
			$('.codepay').show();
		}else{
			$('.codepay').hide();
		}
			
		if(p1 == 'xhpay'){
			$('.xhpay').show();
		}else{
			$('.xhpay').hide();
		}
　　});
　　　　
　　$('#wxpay_option').change(function(){
		var p2 = $(this).children('option:selected').val();
			
		if(p2 == 'wxpay'){
			$('.wxpay').show();
		}else{
			$('.wxpay').hide();
		}
			
		if(p2 == 'payjs'){
			$('.payjs').show();
		}else{
			$('.payjs').hide();
		}
			
		if(p2 == 'xhpay'){
			$('.xhwxpay').show();
		}else{
			$('.xhwxpay').hide();
		}
　　});

 });
  
  
})( jQuery, window, document );