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
 * Event observers
 *
 * @package    local_newsforumsubscribe
 * @copyright  2017 eWallah
 * @author     Renaat Debleu (info@eWallah.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_newsforumsubscribe;

defined('MOODLE_INTERNAL') || die();

/**
 * Event observers
 *
 * @package    local_newsforumsubscribe
 * @copyright  2017 eWallah
 * @author     Renaat Debleu (info@eWallah.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class observer {

    /**
     * Create instance of event.
     *
     * @param \core\event\user_created $user new user
     */
    public static function usercreated(\core\event\user_created $user) {
        if (!empty($user)) {
            $adhock = new usercreated_task();
            $adhock->set_custom_data(['userid' => $user->objectid]);
            $adhock->set_component('local_newsforumsubscribe');
            \core\task\manager::queue_adhoc_task($adhock);
        }
    }
}
