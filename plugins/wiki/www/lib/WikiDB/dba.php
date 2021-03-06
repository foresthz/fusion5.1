<?php // $Id: dba.php 7956 2011-03-03 17:08:31Z vargenau $

require_once('lib/WikiDB.php');
require_once('lib/WikiDB/backend/dba.php');
/**
 *
 */
class WikiDB_dba extends WikiDB
{
    function WikiDB_dba ($dbparams) {
        $backend = new WikiDB_backend_dba($dbparams);
        $this->WikiDB($backend, $dbparams);

        if (empty($dbparams['directory'])
            || preg_match('@^/tmp\b@', $dbparams['directory']))
            trigger_error(sprintf(_("The %s files are in the %s directory. Please read the INSTALL file and move the database to a permanent location or risk losing all the pages!"),
                                  "DBA", "/tmp"), E_USER_WARNING);
    }
};

// Local Variables:
// mode: php
// tab-width: 8
// c-basic-offset: 4
// c-hanging-comment-ender-p: nil
// indent-tabs-mode: nil
// End: 
?>
