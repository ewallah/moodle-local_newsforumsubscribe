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
 * Installation of local newsforumsubscribe
 *
 * @package    local_newsforumsubscribe
 * @copyright  2017 eWallah
 * @author     Renaat Debleu (info@eWallah.net)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post installation procedure
 *
 * @see upgrade_plugins_modules()
 */
function xmldb_local_newsforumsubscribe_install() {
    global $DB;
    $params = ['course' => 1, 'type' => 'news', 'forcesubscribe' => 1];
    if ($forum = $DB->get_record('forum', $params)) {
        if ($DB->set_field('forum', 'forcesubscribe', 0, $params)) {
            if ($userids = $DB->get_fieldset_select('user', 'id', 'confirmed = 1 AND deleted = 0 AND suspended = 0')) {
                foreach ($userids as $userid) {
                    $sub = new \stdClass();
                    $sub->userid  = $userid;
                    $sub->forum = $forum->id;
                    $DB->insert_record("forum_subscriptions", $sub);
                }
            }
        }
    }
}
