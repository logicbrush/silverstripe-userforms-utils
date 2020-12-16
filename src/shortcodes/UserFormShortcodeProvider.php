<?php

namespace Logicbrush\UserFormsUtils\Shortcodes;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\i18n\i18n;
use SilverStripe\UserForms\Control\UserDefinedFormController;
use SilverStripe\UserForms\Model\UserDefinedForm;
use SilverStripe\View\Parsers\ShortcodeHandler;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Requirements;

/**
 * Provider for the [user_form] shortcode tag used to embed a user form
 * in the HTML Editor field.
 */
class UserFormShortcodeProvider implements ShortcodeHandler
{
    use Configurable;

    /**
     * Set this to true to disable automatic inclusion of UserForms CSS and Javascript files
     * @config
     * @var bool
     */
    private static $block_default_userforms_requirements = false;

    /**
     * Gets the list of shortcodes provided by this handler
     *
     * @return string[]
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
        $data = $form->getSessionData();
        $validationResult = $form->getSessionValidationResult();

        $formEscapedForRegex = addcslashes($form->forTemplate(), '\\$');

        if (is_array($data)) {
            $form->setSessionData($data);
        }

        if (isset($validationResult)) {
            $form->setSessionValidationResult($validationResult);
        }

        self::loadUserFormsRequirements();

        return $formEscapedForRegex;
    }

    protected static function loadUserFormsRequirements()
    {
        if (self::config()->get('block_default_userforms_requirements')) {
            return;
        }

        if (!UserDefinedForm::config()->get('block_default_userforms_css')) {
            Requirements::css('silverstripe/userforms:client/dist/styles/userforms.css');
        }

        if (!UserDefinedForm::config()->get('block_default_userforms_js')) {
            //Requirements::javascript('//code.jquery.com/jquery-3.4.1.min.js');
            Requirements::javascript(
                'silverstripe/userforms:client/thirdparty/jquery-validate/jquery.validate.min.js'
            );
            Requirements::javascript('silverstripe/admin:client/dist/js/i18n.js');
            Requirements::add_i18n_javascript('silverstripe/userforms:client/lang');
            Requirements::javascript('silverstripe/userforms:client/dist/js/userforms.js');

            self::addUserFormsValidatei18n();

            // Bind a confirmation message when navigating away from a partially completed form.
            if (UserDefinedForm::config()->get('enable_are_you_sure')) {
                Requirements::javascript(
                    'silverstripe/userforms:client/thirdparty/jquery.are-you-sure/jquery.are-you-sure.js'
                );
            }
        }
    }

    protected static function addUserFormsValidatei18n()
    {
        $module = ModuleLoader::getModule('silverstripe/userforms');

        $candidates = [
            i18n::getData()->langFromLocale(i18n::config()->get('default_locale')),
            i18n::config()->get('default_locale'),
            i18n::getData()->langFromLocale(i18n::get_locale()),
            i18n::get_locale(),
        ];

        foreach ($candidates as $candidate) {
            foreach (['messages', 'methods'] as $candidateType) {
                $localisationCandidate = "client/thirdparty/jquery-validate/localization/{$candidateType}_{$candidate}.min.js";

                $resource = $module->getResource($localisationCandidate);
                if ($resource->exists()) {
                    Requirements::javascript($resource->getRelativePath());
                }
            }
        }
    }
}
