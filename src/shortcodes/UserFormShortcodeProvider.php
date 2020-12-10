<?php

namespace Logicbrush\UserFormsUtils\Shortcodes;

use SilverStripe\UserForms\Control\UserDefinedFormController;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\Parsers\ShortcodeParser;

/**
 * Provider for the [user_form] shortcode tag used to embed a user form
 * in the HTML Editor field.
 */
class UserFormShortcodeProvider implements ShortcodeHandler
{
    /**
     * Gets the list of shortcodes provided by this handler
     *
     * @return mixed
     */
    public static function get_shortcodes()
    {
        return [
            'user_form',
        ];
    }

    /**
     * Replace "[user_form id=n]" shortcode with a user form.
     *
     * @param array $args Arguments passed to the parser
     * @param string $content Raw shortcode
     * @param ShortcodeParser $parser Parser
     * @param string $shortcode Name of shortcode used to register this handler
     * @param array $extra Extra arguments
     * @return string Result of the handled shortcode
     */
    public static function handle_shortcode($args, $content, $parser, $shortcode, $extra = [])
    {
        if (!isset($args['id']) || !$args['id']) {
            return '';
        }

        $formID = $args['id'];

        $userDefinedForm = UserDefinedForm::get()->byID($formID);

        if (!$userDefinedForm) {
            return '';
        }

        $userDefinedFormController = UserDefinedFormController::create($userDefinedForm);

        $form = $userDefinedFormController->Form();
        $formEscapedForRegex = addcslashes($form->forTemplate(), '\\$');

        return $formEscapedForRegex;
    }
}
