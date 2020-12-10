<?php

use Logicbrush\UserFormsUtils\Shortcodes\UserFormShortcodeProvider;
use SilverStripe\View\Parsers\ShortcodeParser;

$parser = ShortcodeParser::get('default');
$parser->register('user_form', [UserFormShortcodeProvider::class, 'handle_shortcode']);
