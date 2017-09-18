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
 * Ad hoc subscribe new users to news forum
 *
 * @package    local_newsforumsubscribe
 * @copyright  2017 eWallah
 * @author     Renaat Debleu (info@eWallah.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Ad hoc subscribe new users to news forum
 *
 * @package    local_newsforumsubscribe
 * @copyright  2017 eWallah
 * @author     Renaat Debleu (info@eWallah.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_newsforumsubscribe_usercreated_task extends \core\task\adhoc_task {

    /**
     * Execute scheduled task
     *
     * @return boolean
     */
    public function execute() {
        global $CFG, $DB;
        $data = $this->get_custom_data();
        if ($forum = $DB->get_record('forum', ['courseid' => 1, 'type' => 'news'])) {
            $id = $data->userid;
            \mod_forum\subscriptions::subscribe_user($id, $forum);
            mtrace("User $id subscribed");
        }
        return true;
    }
}