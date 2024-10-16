<?php


namespace Logicbrush\UserFormsUtils\FormFields;

use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\i18n\i18n;
use SilverStripe\UserForms\Model\EditableCustomRule;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableDropdown;

/**
 * A dropdown field which allows the user to select a US State
 *
 * @property bool $UseEmptyString
 * @property string $EmptyString
 */


class EditableUSStateDropdownField extends EditableFormField {

	private static $singular_name = 'US State Dropdown';
	private static $plural_name = 'US State Dropdowns';

	private static $db = ['UseEmptyString' => 'Boolean', 'EmptyString' => 'Varchar(255)'];

	private static $table_name = 'EditableUSStateDropdownField';

	private static array $list_of_states = [
		'AL' => "Alabama",
		'AK' => "Alaska",
		'AZ' => "Arizona",
		'AR' => "Arkansas",
		'CA' => "California",
		'CO' => "Colorado",
		'CT' => "Connecticut",
		'DE' => "Delaware",
		'DC' => "District Of Columbia",
		'FL' => "Florida",
		'GA' => "Georgia",
		'HI' => "Hawaii",
		'ID' => "Idaho",
		'IL' => "Illinois",
		'IN' => "Indiana",
		'IA' => "Iowa",
		'KS' => "Kansas",
		'KY' => "Kentucky",
		'LA' => "Louisiana",
		'ME' => "Maine",
		'MD' => "Maryland",
		'MA' => "Massachusetts",
		'MI' => "Michigan",
		'MN' => "Minnesota",
		'MS' => "Mississippi",
		'MO' => "Missouri",
		'MT' => "Montana",
		'NE' => "Nebraska",
		'NV' => "Nevada",
		'NH' => "New Hampshire",
		'NJ' => "New Jersey",
		'NM' => "New Mexico",
		'NY' => "New York",
		'NC' => "North Carolina",
		'ND' => "North Dakota",
		'OH' => "Ohio",
		'OK' => "Oklahoma",
		'OR' => "Oregon",
		'PA' => "Pennsylvania",
		'RI' => "Rhode Island",
		'SC' => "South Carolina",
		'SD' => "South Dakota",
		'TN' => "Tennessee",
		'TX' => "Texas",
		'UT' => "Utah",
		'VT' => "Vermont",
		'VA' => "Virginia",
		'WA' => "Washington",
		'WV' => "West Virginia",
		'WI' => "Wisconsin",
		'WY' => "Wyoming",
	];

	/**
	 *
	 * @Metrics( crap = 2, uncovered = true )
	 * @return FieldList
	 */
	public function getCMSFields() {
		$this->beforeUpdateCMSFields( function ( FieldList $fields ) {
				$fields->removeByName( 'Default' );
				$fields->addFieldToTab(
					'Root.Main',
					DropdownField::create( 'Default', _t( self::class . '.DEFAULT', 'Default value' ) )
					->setSource( self::$list_of_states )
					->setHasEmptyDefault( true )
					->setEmptyString( '---' )
				);

				$fields->addFieldToTab(
					'Root.Main',
					CheckboxField::create( 'UseEmptyString', _t( self::class . '.USE_EMPTY_STRING', 'Set default empty string' ) )
				);

				$fields->addFieldToTab(
					'Root.Main',
					TextField::create( 'EmptyString', _t( self::class . '.EMPTY_STRING', 'Empty String' ) )
				);
			} );

		return parent::getCMSFields();
	}


	/**
	 *
	 * @Metrics( crap = 30, uncovered = true )
	 * @return unknown
	 */
	public function getFormField() {
		$field = DropdownField::create( $this->Name, $this->Title ?: false )
		->setFieldHolderTemplate( EditableFormField::class . '_holder' )
		->setTemplate( EditableDropdown::class )
		->setSource( self::$list_of_states )
		;

		// Empty string
		if ( $this->UseEmptyString ) {
			$field->setEmptyString( $this->EmptyString ?: '' );
		}

		// Set default
		if ( $this->Default ) {
			$field->setValue( $this->Default );
		}

		$this->doUpdateFormField( $field );

		return $field;
	}


	/**
	 *
	 * @Metrics( crap = 6, uncovered = true )
	 * @param unknown $data
	 * @return unknown
	 */
	public function getValueFromData( $data ) {
		if ( ! empty( $data[$this->Name] ) ) {
			$source = $this->getFormField()->getSource();
			return $source[$data[$this->Name]];
		}
		return null;
	}


	/**
	 *
	 * @Metrics( crap = 6, uncovered = true )
	 * @return unknown
	 */
	public function getIcon() {
		$resource = ModuleLoader::getModule( 'silverstripe/userforms' )->getResource( 'images/editabledropdown.png' );

		if ( ! $resource->exists() ) {
			return '';
		}

		return $resource->getURL();
	}


	/**
	 *
	 * @Metrics( crap = 2, uncovered = true )
	 * @param unknown $forOnLoad (optional)
	 * @return unknown
	 */
	public function getSelectorField( EditableCustomRule $rule, $forOnLoad = false ) {
		return "$(\"select[name='{$this->Name}']\")";
	}


}
