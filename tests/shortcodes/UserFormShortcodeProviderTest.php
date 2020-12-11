<?php

namespace Logicbrush\UserFormsUtils\Tests\Shortcodes;

use Logicbrush\UserFormsUtils\Shortcodes\UserFormShortcodeProvider;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\UserForms\Model\EditableFormField\EditableTextField;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\View\Parsers\ShortcodeParser;

class UserFormShortcodeProviderTest extends FunctionalTest
{
    protected $usesDatabase = true;

    public function testSuccess()
    {
        $userDefinedForm = new UserDefinedForm();
        $userDefinedForm->Title = 'User Defined Form';
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();

        $textField = new EditableTextField();
        $textField->Name = 'text-field';
        $textField->Title = 'Text field';
        $textField->write();
        $textField->publishRecursive();

        $userDefinedForm->Fields()->add($textField);

        $this->assertNotNull($userDefinedForm);

        $parser = new ShortcodeParser();
        $parser->register('userform', [UserFormShortcodeProvider::class, 'handle_shortcode']);

        $result = $parser->parse('[userform id=' . $userDefinedForm->ID . ']');

        $this->assertContains('<form', $result);
        $this->assertContains('<input type="text" name="text-field"', $result);
    }

    public function testFailure()
    {
        $parser = new ShortcodeParser();
        $parser->register('userform', [UserFormShortcodeProvider::class, 'handle_shortcode']);

        $this->assertEquals('', $parser->parse('[userform]'));
        $this->assertEquals('', $parser->parse('[userform id=100]'));
    }

    public function testGetShortcodes()
    {
        $this->assertEquals(['user_form'], UserFormShortcodeProvider::get_shortcodes());
    }
}
