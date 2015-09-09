<?php

/**
 * Serviio class
 *
 * @category   apps
 * @package    serviio
 * @subpackage libraries
 * @author     Fredrik Fornstad <fredrik.fornstad@gmail.com>
 * @copyright  2015
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Lesser General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// N A M E S P A C E
///////////////////////////////////////////////////////////////////////////////

namespace clearos\apps\serviio;

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('serviio');

///////////////////////////////////////////////////////////////////////////////
// D E P E N D E N C I E S
///////////////////////////////////////////////////////////////////////////////

// Classes
//--------

use \clearos\apps\base\Daemon as Daemon;
use \clearos\apps\base\File as File;
use \clearos\apps\base\Shell as Shell;

clearos_load_library('base/Daemon');
clearos_load_library('base/File');
clearos_load_library('base/Shell');

// Exceptions
//-----------

use \Exception as Exception;
use \clearos\apps\base\Engine_Exception as Engine_Exception;
use \clearos\apps\base\Validation_Exception as Validation_Exception;

clearos_load_library('base/Engine_Exception');
clearos_load_library('base/Validation_Exception');

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Serviio class
 *
 * @category   apps
 * @package    serviio
 * @subpackage libraries
 * @author     Fredrik Fornstad <fredrik.fornstad@gmail.com>
 * @copyright  2015
 * @license    http://www.gnu.org/copyleft/lgpl.html GNU Lesser General Public License version 3 or later
 */

class Serviio extends Daemon
{
    ///////////////////////////////////////////////////////////////////////////////
    // V A R I A B L E S
    ///////////////////////////////////////////////////////////////////////////////

    const COMMAND_HTPASSWD = '/usr/clearos/sandbox/usr/bin/htpasswd';
    const FILE_USER_CONFIG = '/etc/serviio/webconfig.users';
 
    ///////////////////////////////////////////////////////////////////////////////
    // M E T H O D S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Serviio constructor.
     */

    public function __construct()
    {
        clearos_profile(__METHOD__, __LINE__);

        parent::__construct('serviio');
    }

    /**
     * Checks that the password for given hostname is set.
     *
     * @param string $username username
     * @param string $hostname hostname
     *
     * @return boolean TRUE if set
     * @throws Engine_Exception, Validation_Exception
     */

    public function is_password_set($username)
    {
        clearos_profile(__METHOD__, __LINE__);

        Validation_Exception::is_valid($this->validate_username($username));

        $options['validate_exit_code'] = FALSE;

        try {
	     $file = new File(self::FILE_USER_CONFIG);
            $retval = $file->lookup_value("/^serviio/i");
            if ($retval == 0)
                return FALSE;
            else
                return TRUE;
        } catch (File_No_Match_Exception $e) {
            return FALSE;
        }

    }

    /**
     * Checks that the password for localhost.
     *
     * @return boolean TRUE if set
     * @throws Engine_Exception
     */

    public function is_root_password_set()
    {
        clearos_profile(__METHOD__, __LINE__);

        if ($this->is_password_set('serviio'))
            return TRUE;
        else
            return FALSE;
    }

    /**
     * Sets the database password for localhost and hostname.
     *
     * @param string $username     username
     * @param string $old_password old password
     * @param string $password     password
     *
     * @return void
     * @throws Engine_Exception, Validation_Exception
     */

    public function set_password($username, $password)
    {
        clearos_profile(__METHOD__, __LINE__);

        Validation_Exception::is_valid($this->validate_username($username));
        Validation_Exception::is_valid($this->validate_password($password));

        try {
            $options = array();
            $options['env'] = 'LANG=en_US'; 
            $args = "-b -c " . self::FILE_USER_CONFIG . " " . $username . " " . $password;
            $shell = new Shell();
            $shell->Execute(
                self::COMMAND_HTPASSWD, $args, FALSE, $options
            );
        } catch (Engine_Exception $e) {
            throw new Engine_Exception($e);
        }

    }


    ///////////////////////////////////////////////////////////////////////////////
    // V A L I D A T I O N   R O U T I N E S
    ///////////////////////////////////////////////////////////////////////////////

    /**
     * Validates password.
     *
     * @param string $password password
     *
     * @return string error message if password is invalid
     */

    public function validate_password($password)
    {
        clearos_profile(__METHOD__, __LINE__);

        // TODO
        // if (empty($password))
    }

    /**
     * Validates password/verify.
     *
     * @param string $password password
     * @param string $verify   verify password
     *
     * @return string error message if passwords do not match
     */

    public function validate_password_verify($password, $verify)
    {
        clearos_profile(__METHOD__, __LINE__);

        if ($password != $verify)
            return lang('serviio_password_mismatch');
    }

    /**
     * Validates username.
     *
     * @param string $username username
     *
     * @return string error message if username is invalid
     */

    public function validate_username($username)
    {
        clearos_profile(__METHOD__, __LINE__);

        if (! preg_match('/^([a-z0-9_\-\.\$]+)$/', $username))
            return lang('serviio_username_invalid');
    }
}
