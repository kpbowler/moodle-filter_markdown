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
 * Unit test for the filter_markdown
 *
 * @package    filter
 * @subpackage markdown
 * @copyright  2020 onwards Kevin Bowler  {@link http://kpbowler.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/markdown/filter.php');

class filter_markdown_testcase extends advanced_testcase {

    protected $filter;

    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
        $this->filter = new filter_markdown(context_system::instance(), array());
    }

    function run_with_markdown($markdown, $filtershouldrun) {
        $text = $this->filter->filter($markdown);
        error_log($text);

        $match = '<h1>Title</h1>';

        if ($filtershouldrun) {
            $this->assertEquals($match, $text);
        } else {
            $this->assertNotEquals($match, $text);
        }
    }

    function test_markdown() {
        $this->run_with_markdown('#Title', true);
        $this->run_with_markdown('     #  Title', false);
    }

}