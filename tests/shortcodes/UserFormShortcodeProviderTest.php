<?php

namespace Logicbrush\UserFormsUtils\Tests\Shortcodes;

use Logicbrush\UserFormsUtils\Shortcodes\UserFormShortcodeProvider;
use SilverStripe\Dev\FunctionalTest;
use SilverStripe\i18n\i18n;
use SilverStripe\UserForms\Model\EditableFormField\EditableTextField;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Requirements;

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

        $this->assertStringContainsString('<form', $result);
        $this->assertStringContainsString('<input type="text" name="text-field"', $result);
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

    public function testRequirements()
    {
        UserFormShortcodeProvider::config()->set('block_default_userforms_requirements', false);

        $userDefinedForm = new UserDefinedForm();
        $userDefinedForm->write();
        $userDefinedForm->publishRecursive();

        $parser = new ShortcodeParser();
        $parser->register('userform', [UserFormShortcodeProvider::class, 'handle_shortcode']);
        $parser->parse('[userform id=' . $userDefinedForm->ID . ']');

        $requirements = Requirements::backend();

        $enJavascriptCount = count($requirements->getJavascript());

        $this->assertTrue($enJavascriptCount > 0);
        $this->assertTrue(count($requirements->getCSS()) > 0);

        Requirements::clear();
        UserFormShortcodeProvider::config()->set('block_default_userforms_requirements', true);

        $parser->parse('[userform id=' . $userDefinedForm->ID . ']');

        $this->assertTrue(count($requirements->getJavascript()) === 0);
        $this->assertTrue(count($requirements->getCSS()) === 0);

        Requirements::clear();
        UserFormShortcodeProvider::config()->set('block_default_userforms_requirements', false);
        i18n::config()->set('default_locale', 'de');

        $parser->parse('[userform id=' . $userDefinedForm->ID . ']');

        $deJavascriptCount = count($requirements->getJavascript());

        $this->assertTrue($deJavascriptCount > 0);
        $this->assertTrue($deJavascriptCount > $enJavascriptCount);
    }
}
