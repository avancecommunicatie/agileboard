<?php
/**
 * Make a bootstrap ready datepicker field
 * @param $name string
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsDatepicker', function($name, $value = null, $attributes = []){
	return view('backoffice.macros.form.date',
		['name' => $name, 'value' => $value, 'attributes' => $attributes]
	)->render();
});

/**
 * Make a bootstrap ready datepicker field
 * @param $name string
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsClockpicker', function($name, $value = null, $attributes = []){
	return view('backoffice.macros.form.clock',
		['name' => $name, 'value' => $value, 'attributes' => $attributes]
	)->render();
});

/**
 * Make a bootstrap ready price field
 * @param $name string
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsPrice', function($name, $value = null, $attributes = []){
	return view('backoffice.macros.form.price',
		['name' => $name, 'value' => $value, 'attributes' => $attributes]
	)->render();
});

/**
 * Make a bootstrap ready input text field
 * @param $name string
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsText', function($name, $value = null, $attributes = []){
	$class = 'form-control';
	if(isset($attributes['class'])){
		$class .= ' '.$attributes['class'];
	}
	$attributes['class'] = $class;
	return Collective\Html\FormBuilder::text($name, $value, $attributes);
});

/**
 * Make a bootstrap ready textarea field
 * @param $name string
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsTextarea', function($name, $value = null, $attributes = []){
	$class = 'form-control';
	if(isset($attributes['class'])){
		$class .= ' '.$attributes['class'];
	}
	$attributes['class'] = $class;
	return Collective\Html\FormBuilder::textarea($name, $value, $attributes);
});

/**
 * Make a bootstrap ready number field
 * @param $name string
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsNumber', function($name, $value = null, $attributes = []){
	$class = 'form-control';
	if(isset($attributes['class'])){
		$class .= ' '.$attributes['class'];
	}
	$attributes['class'] = $class;
	return Collective\Html\FormBuilder::number($name, $value, $attributes);
});

/**
 * Make a bootstrap ready select field
 * @param $name string
 * @param $values array
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('bsSelect', function($name, $values = [],$value = null, $attributes = []){
	$class = 'form-control';
	if(isset($attributes['class'])){
		$class .= ' '.$attributes['class'];
	}
	$attributes['class'] = $class;
	return Collective\Html\FormBuilder::select($name, $values, $value, $attributes);
});

/**
 * Make a radio button
 * @param string $name name of the element
 * @param mixed $value the value to submit when checked
 * @param boolean $checked if checked
 * @param array $properties element properties like class, style, etc
 * @return string
 */
Collective\Html\FormBuilder::macro('bsRadio', function($name, $val, $checked, $label, $properties = false){
	$prp = false;
	if($properties){
		foreach( $properties as $pk => $pv ) {
			$prp .= $pk.'="'.(is_array($pv) ? implode(';',$pv).';' : $pv ).'" ';
		}
	}
	return '<input type="radio" name="'.$name.'" value="'.$val.'"'.( $checked === true ? ' checked ' : ' ' ).$prp.'/> ' . $label;
});
/**
 * Make a radio button with the icheck theme
 * @param string $name name of the element
 * @param mixed $value the value to submit when checked
 * @param boolean $checked if checked
 * @param array $properties element properties like class, style, etc
 * @return string
 */
Collective\Html\FormBuilder::macro('iRadio', function($name, $val, $checked, $properties = []){
	$class = 'i-checks';

	if (isset($properties['class'])) {
		$class .= ' '.$properties['class'];
	}
	$properties['class'] = $class;

	if(! isset($properties['id'])){
		$properties['id'] = $name;
	}

	$prp = false;
	if($properties){
		foreach( $properties as $pk => $pv ) {
			$prp .= $pk.'="'.(is_array($pv) ? implode(';',$pv).';' : $pv ).'" ';
		}
	}

	return Collective\Html\FormBuilder::radio($name, $val, $checked, $properties);
});

/**
 * Make a icheck checkbox
 * @param $name string
 * @param $checked bool
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('icheck', function($name, $checked = false, $value = 1,$attributes = []){
	$class = 'i-checks';
	if(isset($attributes['class'])){
		$class .= ' '.$attributes['class'];
	}
	$attributes['class'] = $class;

	if(! isset($attributes['id'])){
		$attributes['id'] = $name;
	}

	return Collective\Html\FormBuilder::checkbox($name, $value, $checked, $attributes);
});

/**
 * Make a select2 widget
 * @param $name string
 * @param $values array
 * @param $value mixed
 * @param $attributes array
 * @return string
 */
Collective\Html\FormBuilder::macro('select2', function($name, $values = [],$value = null, $attributes = []){
	$class = 'select2-basic';
	if(isset($attributes['class'])){
		$class .= ' '.$attributes['class'];
	}
	$attributes['class'] = $class;
	return Collective\Html\FormBuilder::bsSelect($name, $values, $value, $attributes);
});

/**
 * Make a dropzone fileupload widget
 * @param $elementid int
 * @param $uri string
 * @param $limit int
 * @param $create bool
 * @return string
 */
Collective\Html\Formbuilder::macro('dropzone', function($elementid = null, $uri = null, $limit = 1, $create = false) {
	if( empty($uri) ) {
		return 'URI required';
	}
	if ( is_null($elementid) ) {
		$elementid = 'filedropzone';
	}
	return view('backoffice.macros.form.dropzone', ['element' => $elementid, 'uri' => $uri, 'limit' => $limit, 'create' => $create])->render();
});

/**
 * Make a simple search form
 * @return string
 */
Collective\Html\FormBuilder::macro('simpleSearch', function($name = 's'){
	return view('backoffice.macros.form.simple-search', ['name' => $name])->render();
});