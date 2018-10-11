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
 * Other tests for local newsforumsubscribe.
 *
 * @package   local_newsforumsubscribe
 * @copyright 2018 eWallah
 * @author    Renaat Debleu <info@eWallah.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * Other tests for local newsforumsubscribe.
 *
 * @package   local_newsforumsubscribe
 * @copyright 2018 eWallah.net
 * @author    Renaat Debleu <info@eWallah.net>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_newsforumsubscribe_other_testcase extends advanced_testcase {

    /**
     * Tests the task.
     */
    public function test_local_task() {
        $this->resetAfterTest();
        $this->setAdminUser();
        $generator = $this->getDataGenerator();
        $course = get_course(1);
        $generator->create_module('forum', ['course' => $course, 'type' => 'news', 'forcesubscribe' => 1]);
        $sink = $this->redirectEvents();
        $user = $generator->create_user();
        $event = \core\event\user_created::create_from_userid($user->id);
        $event->trigger();
        \local_newsforumsubscribe_observer::usercreated($event);
        $events = $sink->get_events();
        $sink->close();
        $this->assertCount(1, $events);
        ob_start();
        phpunit_util::run_all_adhoc_tasks();
        $data = ob_get_contents();
        ob_end_clean();
        $this->assertContains("User $user->id subscribed", $data);
    }
}