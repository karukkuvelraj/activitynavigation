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
 * This file contains the navigation for the list of activities in a course.
 *
 * @package    block_activitynavigation
 * @copyright  2023 Karukkuvelraj B
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/filelib.php');

class block_activitynavigation extends block_list {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_activitynavigation');
    }

    /**
     * Gets the block contents.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        global $CFG, $DB, $OUTPUT, $USER;
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $course = $this->page->course;
        $modinfo = course_modinfo::get_array_of_activities($course, true);
        foreach ($modinfo as $moduledata => $moduled) {
            $coursemoduledata = $DB->get_record_sql("SELECT cmc.id FROM {course_modules_completion} cmc
            WHERE cmc.coursemoduleid = $moduled->cm AND cmc.userid=$USER->id AND cmc.completionstate IN (1,2)");
            $completionstate = 'Not-Completed';
            if ($coursemoduledata) {
                $completionstate = 'Completed';
            }
            $this->content->items[] = '<a href="'.$CFG->wwwroot.'/mod/'.$moduled->mod.'/view.php?id='.$moduled->cm.'">
            '.$moduled->cm.'-'.$moduled->name.'-'.date('d-M-Y', $moduled->added).'-'.$completionstate.'</a>';

        }
        return $this->content;
    }

    /**
     * Returns the role that best describes the activity navigation block.
     *
     * @return string
     */
    public function get_aria_role() {
        return 'navigation';
    }

    /**
     * allow the block to appear in all course formats.
     *
     * @return array
     */
    public function applicable_formats() {
        return array('course-view' => true);
    }
}
