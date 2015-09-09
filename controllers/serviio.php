<?php

/**
 * Serviio
 *
 * @category   apps
 * @package    serviio
 * @subpackage controllers
 * @author     Fredrik Fornstad <fredrik.fornstad@gmail.com>
 * @copyright  2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Serviio Controller.
 *
 * @category   apps
 * @package    serviio
 * @subpackage controllers
 * @author     Fredrik Fornstad <fredrik.fornstad@gmail.com>
 * @copyright  2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 */


use \Exception as Exception; 

class Serviio extends ClearOS_Controller {

	function index() 
	{

        // Load libraries (we have none but they might look like)
        //---------------

        $this->lang->load('serviio');

        // Load views (default summary.php)
        //--------------

        $views = array(
            'serviio/server',
            'serviio/setting'
        );

        $this->page->view_forms($views, lang('serviio_app_name'));

	}

}

?>
