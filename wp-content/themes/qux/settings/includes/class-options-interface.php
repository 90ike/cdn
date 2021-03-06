<?php
/**
 * @package   Options_Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2014 WP Theming
 */

class Options_Framework_Interface {

	/**
	 * Generates the tabs that are used in the options menu
	 */
	static function optionsframework_tabs() {
		$counter = 0;
		$options = & Options_Framework::_optionsframework_options();
		$menu = '';

		foreach ( $options as $value ) {
			// Heading for Navigation
			if ( $value['type'] == "heading" ) {
				$counter++;
				$class = '';
				$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
				$class = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower($class) ) . '-tab';
				$menu .= '<a id="options-group-'.  $counter . '-tab" class="nav-tab ' . $class .'" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#options-group-'.  $counter ) . '">' . esc_html( $value['name'] ) . '</a>';
			}
		}

		return $menu;
	}

	/**
	 * Generates the options fields that are used in the form.
	 */
	static function optionsframework_fields() {

		global $allowedtags;

		$options_framework = new Options_Framework;
		$option_name = $options_framework->get_option_name();
		$settings = get_option( $option_name );
		$options = & Options_Framework::_optionsframework_options();

		$counter = 0;
		$menu = '';

		foreach ( $options as $value ) {

			$val = '';
			$select_value = '';
			$output = '';

			// Wrap all options
			if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {

				// Keep all ids lowercase with no spaces
				$value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );

				$id = 'section-' . $value['id'];

				$class = 'section';
				if ( isset( $value['type'] ) ) {
					$class .= ' section-' . $value['type'];
				}
				if ( isset( $value['class'] ) ) {
					$class .= ' ' . $value['class'];
				}

				$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
				if ( isset( $value['name'] ) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				if ( $value['type'] != 'editor' ) {
					$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
				}
				else {
					$output .= '<div class="option">' . "\n" . '<div>' . "\n";
				}
			}

			// Set default value to $val
			if ( isset( $value['std'] ) ) {
				$val = $value['std'];
			}

			// If the option is already saved, override $val
			if ( ( $value['type'] != 'heading' ) && ( $value['type'] != 'info') ) {
				if ( isset( $settings[($value['id'])]) ) {
					$val = $settings[($value['id'])];
					// Striping slashes of non-array options
					if ( !is_array($val) ) {
						$val = stripslashes( $val );
					}
				}
			}

			// If there is a description save it for labels
			$explain_value = '';
			if ( isset( $value['desc'] ) ) {
				$explain_value = $value['desc'];
			}

			// Set the placeholder if one exists
			$placeholder = '';
			if ( isset( $value['placeholder'] ) ) {
				$placeholder = ' placeholder="' . esc_attr( $value['placeholder'] ) . '"';
			}

			if ( has_filter( 'optionsframework_' . $value['type'] ) ) {
				$output .= apply_filters( 'optionsframework_' . $value['type'], $option_name, $value, $val );
			}


			switch ( $value['type'] ) {

			// Basic text input
			case 'text':
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '"' . $placeholder . ' />';
				break;

			// Password input
			case 'password':
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="password" value="' . esc_attr( $val ) . '" />';
				break;

			// Textarea
			case 'textarea':
				$rows = '8';

				if ( isset( $value['settings']['rows'] ) ) {
					$custom_rows = $value['settings']['rows'];
					if ( is_numeric( $custom_rows ) ) {
						$rows = $custom_rows;
					}
				}

				$val = stripslashes( $val );
				$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" rows="' . $rows . '"' . $placeholder . '>' . esc_textarea( $val ) . '</textarea>';
				break;

			// Select Box
			case 'select':
			    $multiple_attr  = ( $value['multiple'] ) ? ' multiple="multiple"' : '';
			    $chosen_attr = ( $value['chosen'] ) ? ' of-chosen select2-sortable' : '';
			    $multiple_name  = ( $value['multiple'] ) ? '[]' : '';
			    $placeholder_attr = ( $value['chosen'] && $value['placeholder'] ) ? ' data-placeholder="'. $value['placeholder'] .'"' : '';
				$output .= '<select class="of-input'.$chosen_attr.'" '.$multiple_attr.$placeholder_attr.' name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) .$multiple_name. '" id="' . esc_attr( $value['id'] ) . '">';

				if(!empty( $value['multiple'] ) && !empty( $val ) && is_array( $val )){
					$origOption = $value['options'];
					$value['options'] = array();
					
					foreach ( $val as $val1 ) {
                        $value['options'][ $val1 ] = $origOption[ $val1 ];
                    }
					
					if ( count( $value['options'] ) < count( $origOption ) ) {
                        foreach ( $origOption as $key => $val2 ) {
                            if ( ! in_array( $key, $value['options'] ) ) {
                                $value['options'][ $key ] = $val2;
                            }
                        }
                    }
					
				}
				
				foreach ($value['options'] as $key => $option ) {
				    if( is_array( $option ) && ! empty( $option ) ) {
						echo '<optgroup label="' . $option . '">';
				        foreach( $option as $sub_key => $sub_value ) {
				            if($value['multiple'] && !empty($val) && is_array($val)){
								$selected = ( in_array( $key, $val ) ) ? ' selected' : '';
							}else{
								$selected = selected( $val, $key, false);
							}
				            $output .= '<option value="'. $sub_key .'" '. $selected .'>'. $sub_value .'</option>';
				        }
						echo '</optgroup>';
				    }else{
				        if(!empty($value['multiple']) && !empty($val) && is_array($val)){
				            $selected = ( in_array( $key, $val ) ) ? ' selected' : '';
				        }else{
				            $selected = selected( $val, $key, false);
				        }
				        $output .= '<option' .$selected.' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
				    }

				}
				$output .= '</select>';
				break;


			// Radio Box
			case "radio":
				$name = $option_name .'['. $value['id'] .']';
				foreach ($value['options'] as $key => $option) {
					$id = $option_name . '-' . $value['id'] .'-'. $key;
					$output .= '<input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
				}
				break;

			// Image Selectors
			case "images":
				$name = $option_name .'['. $value['id'] .']';
				foreach ( $value['options'] as $key => $option ) {
					$selected = '';
					if ( $val != '' && ($val == $key) ) {
						$selected = ' of-radio-img-selected';
					}
					$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. checked( $val, $key, false ) .' />';
					$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
					$output .= '<img src="' . esc_url( $option ) . '" alt="' . $option .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
				}
				break;

			// colorradio Selectors
			case "colorradio":
				$name = $option_name .'['. $value['id'] .']';
				foreach ( $value['options'] as $key=>$key ) {
					$selected = '';
					$checked = '';
					if ( $val != '' ) {
						if ( $val == $key ) {
							$selected = ' of-radio-img-selected';
							$checked = ' checked="checked"';
						}
					}
					$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. $checked .' />';
					$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
					$output .= '<a style="background-color:#'.$key.';" href="javascript:;" class="of-radio-img-img of-radio-color' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;"></a>';
					// $output .= '<img src="' . esc_url( $option ) . '" alt="' . $option .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
				}
				break;


			// Checkbox
			case "checkbox":
				$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' />';
				$output .= '<label class="explain" for="' . esc_attr( $value['id'] ) . '">' . wp_kses( $explain_value, $allowedtags) . '</label>';
				break;

			// Multicheck
			case "multicheck":
				foreach ($value['options'] as $key => $option) {
					$checked = '';
					$label = $option;
					$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));

					$id = $option_name . '-' . $value['id'] . '-'. $option;
					$name = $option_name . '[' . $value['id'] . '][' . $option .']';

					if ( isset($val[$option]) ) {
						$checked = checked($val[$option], 1, false);
					}

					$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
				}
				break;

			// Color picker
			case "color":
				$default_color = '';
				if ( isset($value['std']) ) {
					if ( $val !=  $value['std'] )
						$default_color = ' data-default-color="' .$value['std'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" class="of-color"  type="text" value="' . esc_attr( $val ) . '"' . $default_color .' />';

				break;

			// Uploader
			case "upload":
				$output .= Options_Framework_Media_Uploader::optionsframework_uploader( $value['id'], $val, null );

				break;

			// Typography
			case 'typography':

				unset( $font_size, $font_style, $font_face, $font_color );

				$typography_defaults = array(
					'size' => '',
					'face' => '',
					'style' => '',
					'color' => ''
				);

				$typography_stored = wp_parse_args( $val, $typography_defaults );

				$typography_options = array(
					'sizes' => of_recognized_font_sizes(),
					'faces' => of_recognized_font_faces(),
					'styles' => of_recognized_font_styles(),
					'color' => true
				);

				if ( isset( $value['options'] ) ) {
					$typography_options = wp_parse_args( $value['options'], $typography_options );
				}

				// Font Size
				if ( $typography_options['sizes'] ) {
					$font_size = '<select class="of-typography of-typography-size" name="' . esc_attr( $option_name . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '">';
					$sizes = $typography_options['sizes'];
					foreach ( $sizes as $i ) {
						$size = $i . 'px';
						$font_size .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
					}
					$font_size .= '</select>';
				}

				// Font Face
				if ( $typography_options['faces'] ) {
					$font_face = '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '">';
					$faces = $typography_options['faces'];
					foreach ( $faces as $key => $face ) {
						$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
					}
					$font_face .= '</select>';
				}

				// Font Styles
				if ( $typography_options['styles'] ) {
					$font_style = '<select class="of-typography of-typography-style" name="'.$option_name.'['.$value['id'].'][style]" id="'. $value['id'].'_style">';
					$styles = $typography_options['styles'];
					foreach ( $styles as $key => $style ) {
						$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
					}
					$font_style .= '</select>';
				}

				// Font Color
				if ( $typography_options['color'] ) {
					$default_color = '';
					if ( isset($value['std']['color']) ) {
						if ( $val !=  $value['std']['color'] )
							$default_color = ' data-default-color="' .$value['std']['color'] . '" ';
					}
					$font_color = '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="of-color of-typography-color  type="text" value="' . esc_attr( $typography_stored['color'] ) . '"' . $default_color .' />';
				}

				// Allow modification/injection of typography fields
				$typography_fields = compact( 'font_size', 'font_face', 'font_style', 'font_color' );
				$typography_fields = apply_filters( 'of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
				$output .= implode( '', $typography_fields );

				break;
				
			//fields
			case 'fields':
			    $args = wp_parse_args( $value, array(
			        'max'                    => 0,
			        'min'                    => 0,
			        'fields'                 => array(),
			        'button_title'           => esc_html__( '添加CMS模块', 'haoui' ),
			        'accordion_title_prefix' => '',
			        'accordion_title_number' => false,
			        'accordion_title_auto'   => true,
			    ) );
			    $title_prefix = ( ! empty( $args['accordion_title_prefix'] ) ) ? $args['accordion_title_prefix'] : '';
			    $title_number = ( ! empty( $args['accordion_title_number'] ) ) ? true : false;
			    $title_auto   = ( ! empty( $args['accordion_title_auto'] ) ) ? true : false;
			     
			    $output .= '<div class="csf-cloneable-item csf-cloneable-hidden">';
			    $output .= '<div class="csf-cloneable-helper">';
			    $output .= '<i class="csf-cloneable-sort fa fa-arrows"></i>';
			    $output .= '<i class="csf-cloneable-clone fa fa-clone"></i>';
			    $output .= '<i class="csf-cloneable-remove csf-confirm fa fa-times" data-confirm="'. esc_html__( '确认要删除?', 'haoui' ) .'"></i>';
			    $output .= '</div>';
			     
			    $output .= '<h5 class="csf-cloneable-title">';
			    $output .= '<span class="csf-cloneable-text">';
			    $output .= ( $title_number ) ? '<span class="csf-cloneable-title-number"></span>' : '';
			    $output .= ( $title_prefix ) ? '<span class="csf-cloneable-title-prefix">'. $title_prefix .'</span>' : '';
			    $output .= ( $title_auto ) ? '<span class="csf-cloneable-value"><span class="csf-cloneable-placeholder"></span></span>' : '';
			    $output .= '</span>';
			    $output .= '</h5>';
			     
			    $output .= '<div class="csf-cloneable-content">';
			     
			    foreach ( $value['fields'] as $field ) {
			         
			        switch($field['type']){
			            case  'select':
			                $output .= '<div class="csf-field">';
			                $output .= '<div class="csf-title"><h3>'.$field['name'].'</h3></div><div class="csf-fieldset">';
			                $output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $field['id'] . ']' ) . '" id="' . esc_attr( $field['id'] ) . '">';
			                foreach ($field['options'] as $key => $option ) {			                     
			                    $selected = selected( $val, $key, false);
			                    $output .= '<option' .$selected.' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';			             
			                }
			                $output .= '</select></div>';
			                $output .= '</div>';
			                break;		
			        }
					
			    }
			    $output .= '</div>';
			    $output .= '</div>';
			    $output .= '<div class="csf-cloneable-wrapper csf-data-wrapper" data-title-number="'. $title_number .'" data-unique-id="'. $option_name .'" data-field-id="['. $value['id'] .']" data-max="'. $args['max'] .'" data-min="'. $args['min'] .'">';
				
				//var_dump($val);
				if( ! empty( $val ) ) {
					$num = 0;
					
					foreach ( $val as $value1 ) {
					    
						//$first_id    = ( isset( $value1['fields'][0]['id'] ) ) ? $value1['fields'][0]['id'] : '';
						//$first_value = ( isset( $value1[$first_id] ) ) ? $value1[$first_id] : '';
						foreach ($value['fields'][0]['options'] as $key => $option ) {
							if($value1[$value['fields'][0]['id']] == $key ){
								$first_value = $option;
								break;
							}else{
								$first_value = '';
							}
						}
						
						$output .= '<div class="csf-cloneable-item">';
						$output .= '<div class="csf-cloneable-helper">';
						$output .= '<i class="csf-cloneable-sort fa fa-arrows"></i>';
						$output .= '<i class="csf-cloneable-clone fa fa-clone"></i>';
						$output .= '<i class="csf-cloneable-remove csf-confirm fa fa-times" data-confirm="'. esc_html__( 'Are you sure to delete this item?', 'csf' ) .'"></i>';
						$output .= '</div>';
						
						$output .= '<h5 class="csf-cloneable-title">';
						$output .= '<span class="csf-cloneable-text">';
						$output .= ( $title_number ) ? '<span class="csf-cloneable-title-number">'. ( $num+1 ) .'.</span>' : '';
						$output .= ( $title_prefix ) ? '<span class="csf-cloneable-title-prefix">'. $title_prefix .'</span>' : '';
						$output .= ( $title_auto ) ? '<span class="csf-cloneable-value">' . esc_html($first_value) .'</span>' : '';
						$output .= '</span>';
						$output .= '</h5>';
						
						$output .= '<div class="csf-cloneable-content">';
						
						foreach ( $value['fields'] as $field ) {
							
							$field_unique = $option_name .'['.$value['id'].']['. $num .']['. $field['id'] .']';  
							switch($field['type']){
								case  'select':
								$output .= '<div class="csf-field">';
								$output .= '<div class="csf-title"><h3>'.$field['name'].'</h3></div><div class="csf-fieldset">';
								$output .= '<select class="of-input" name="' . esc_attr( $field_unique ) . '" id="' . esc_attr( $field['id'] ) . '">';
								foreach ($field['options'] as $key => $option ) {
									$selected = selected( $value1[$field['id']], $key, false);
									$output .= '<option' .$selected.' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
								}
								$output .= '</select></div>';
								$output .= '</div>';
								break;
							}
						}
						
						$output .= '</div>';
						$output .= '</div>';
						
						$num++;
					}
				}
				
				$output .= '</div>';
				$output .= '<div class="csf-cloneable-alert csf-cloneable-max">'. esc_html__( '你最多只能添加', 'haoui' ) .' '. $args['max'] .'</div>';
				$output .= '<div class="csf-cloneable-alert csf-cloneable-min">'. esc_html__( '你最少必须留下', 'haoui' ) .' '. $args['min'] .'</div>';
				
				$output .= '<a href="#" class="button button-primary csf-cloneable-add">'. $args['button_title'] .'</a>';
				if( ! wp_script_is( 'jquery-ui-accordion' ) ) {
					wp_enqueue_script( 'jquery-ui-accordion' );
				}
				
				if( ! wp_script_is( 'jquery-ui-sortable' ) ) {
					wp_enqueue_script( 'jquery-ui-sortable' );
				}
				break;
				
			// Background
			case 'background':

				$background = $val;

				// Background Color
				$default_color = '';
				if ( isset( $value['std']['color'] ) ) {
					if ( $val !=  $value['std']['color'] )
						$default_color = ' data-default-color="' .$value['std']['color'] . '" ';
				}
				$output .= '<input name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" class="of-color of-background-color"  type="text" value="' . esc_attr( $background['color'] ) . '"' . $default_color .' />';

				// Background Image
				if ( !isset($background['image']) ) {
					$background['image'] = '';
				}

				$output .= Options_Framework_Media_Uploader::optionsframework_uploader( $value['id'], $background['image'], null, esc_attr( $option_name . '[' . $value['id'] . '][image]' ) );

				$class = 'of-background-properties';
				if ( '' == $background['image'] ) {
					$class .= ' hide';
				}
				$output .= '<div class="' . esc_attr( $class ) . '">';

				// Background Repeat
				$output .= '<select class="of-background of-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
				$repeats = of_recognized_background_repeat();

				foreach ($repeats as $key => $repeat) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
				}
				$output .= '</select>';

				// Background Position
				$output .= '<select class="of-background of-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
				$positions = of_recognized_background_position();

				foreach ($positions as $key=>$position) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
				}
				$output .= '</select>';

				// Background Attachment
				$output .= '<select class="of-background of-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
				$attachments = of_recognized_background_attachment();

				foreach ($attachments as $key => $attachment) {
					$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
				}
				$output .= '</select>';
				$output .= '</div>';

				break;

			// Editor
			case 'editor':
				$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags ) . '</div>'."\n";
				echo $output;
				$textarea_name = esc_attr( $option_name . '[' . $value['id'] . ']' );
				$default_editor_settings = array(
					'textarea_name' => $textarea_name,
					'media_buttons' => false,
					'tinymce' => array( 'plugins' => 'wordpress' )
				);
				$editor_settings = array();
				if ( isset( $value['settings'] ) ) {
					$editor_settings = $value['settings'];
				}
				$editor_settings = array_merge( $default_editor_settings, $editor_settings );
				wp_editor( $val, $value['id'], $editor_settings );
				$output = '';
				break;

			// Info
			case "info":
				$id = '';
				$class = 'section';
				if ( isset( $value['id'] ) ) {
					$id = 'id="' . esc_attr( $value['id'] ) . '" ';
				}
				if ( isset( $value['type'] ) ) {
					$class .= ' section-' . $value['type'];
				}
				if ( isset( $value['class'] ) ) {
					$class .= ' ' . $value['class'];
				}

				$output .= '<div ' . $id . 'class="' . esc_attr( $class ) . '">' . "\n";
				if ( isset($value['name']) ) {
					$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
				}
				if ( isset( $value['desc'] ) ) {
					$output .= $value['desc'] . "\n";
				}
				$output .= '</div>' . "\n";
				break;

			// Heading for Navigation
			case "heading":
				$counter++;
				if ( $counter >= 2 ) {
					$output .= '</div>'."\n";
				}
				$class = '';
				$class = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
				$class = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($class) );
				$output .= '<div id="options-group-' . $counter . '" class="group ' . $class . '">';
				$output .= '<h3>' . esc_html( $value['name'] ) . '</h3>' . "\n";
				break;
			}

			if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {
				$output .= '</div>';
				if ( ( $value['type'] != "checkbox" ) && ( $value['type'] != "editor" ) ) {
					$output .= '<div class="explain">' . wp_kses( $explain_value, $allowedtags) . '</div>'."\n";
				}
				$output .= '</div></div>'."\n";
			}

			echo $output;
		}

		// Outputs closing div if there tabs
		if ( Options_Framework_Interface::optionsframework_tabs() != '' ) {
			echo '</div>';
		}
	}

}