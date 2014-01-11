<?php

/**
 * Serviio controller.
 *
 * @category   apps
 * @package    serviio
 * @subpackage controllers
 * @author     Fredrik Fornstad <fredrik.fornstad@gmail.com>
 * @copyright  2013
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

// Exceptions
//-----------

use \clearos\apps\base\Engine_Exception as Engine_Exception;

clearos_load_library('base/Engine_Exception');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Serviio setting controller.
 *
 * @category   apps
 * @package    serviio
 * @subpackage controllers
 * @author     Fredrik Fornstad <fredrik.fornstad@gmail.com>
 * @copyright  2013
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 */

class Setting extends ClearOS_Controller
{
    /**
     * Serviio default controller
     *
     * @return view
     */

    function index()
    {
        // Load libraries
        //---------------

        $this->load->library('serviio/Serviio');
        $this->lang->load('serviio');

        // Set validation rules
        //---------------------
         
        if ($this->input->post('submit')) {
            $this->form_validation->set_policy('password', 'serviio/Serviio', 'validate_password', TRUE);
            $this->form_validation->set_policy('verify', 'serviio/Serviio', 'validate_password', TRUE);
        }

        $form_ok = $this->form_validation->run();

        // Extra validation
        //-----------------

        if ($this->input->post('submit')) {
            $password = $this->input->post('password');
            $verify = $this->input->post('verify');
        }

        if ($form_ok) {
            if ($password !== $verify) {
                $this->form_validation->set_error('new_verify', lang('base_password_and_verify_do_not_match'));
                $this->form_validation->set_error('verify', lang('base_password_and_verify_do_not_match'));
                $form_ok = FALSE;
            }
        }

        // Handle form submit
        //-------------------

        if (($this->input->post('submit')) && $form_ok) {
            try {
                $this->serviio->set_password('serviio', $password);

                $this->page->set_message(lang('serviio_password_updated'), 'info');
                redirect('/serviio');
            } catch (Exception $e) {
                $this->page->view_exception($e);
            }
        }

        // Load view data
        //---------------

        try {
	    $is_running = $this->serviio->get_running_state();
            //$data['is_password_set'] = $this->serviio->is_root_password_set();
        } catch (Exception $e) {
            $this->page->view_exception($e);
            return;
        }


        // Load views
        //-----------

        $this->page->view_form('serviio/setting', $data, lang('serviio_app_name'));
    }
}
