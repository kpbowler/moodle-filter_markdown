<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'filter_markdown', language 'en'.
 *
 * @package    filter
 * @subpackage markdown
 * @copyright  2020 onwards Kevin Bowler  {@link http://kpbowler.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/locallib.php');

/**
 * Implementation of the Moodle filter API for the Markdown filter.
 *
 * @copyright  2020 onwards Kevin Bowler  {@link http://kpbowler.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_markdown extends moodle_text_filter {
    function filter($text, array $options = array()) {
        global $CFG, $USER;

        $parser = filter_markdown_load_ibrary();

        // Check the roles of the user in the current context to see if they should have output filtered
        if(!is_siteadmin($USER)) {
            $roles = get_user_roles($this->context, $USER->id, true);
            if(!empty($roles)) {
                foreach($roles as $role) {
                    if($role->shortname == 'student') {
                        $parser->setSafeMode(true);
                    }
                }
            }
        }

        $markdown = $parser->text($text);

        if(strlen($markdown) > 0) {
            return $markdown;
        }
        return $text;
    }
}