<?php

class UberMenuItemColumn extends UberMenuItem{

	protected $type = 'column';

	function get_start_el(){

		$this->item_classes[] = 'ubermenu-item-type-column';
		$this->add_class_layout_columns();
		$this->add_class_item_defaults();
		$this->item_classes[] = 'ubermenu-column-id-'.$this->ID;
		$this->add_class_responsive();

		return '<li class="'.implode( ' ' , $this->item_classes ).'">';
	}
}