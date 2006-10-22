<?php
/**
 * PEAR_Command_Install (install, upgrade, upgrade-all, uninstall, bundle, run-scripts commands)
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR
 * @author     Stig Bakken <ssb@php.net>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 0.1
 */

/**
 * base class
 */
require_once 'PEAR/Command/Common.php';

/**
 * PEAR commands for installation or deinstallation/upgrading of
 * packages.
 *
 * @category   pear
 * @package    PEAR
 * @author     Stig Bakken <ssb@php.net>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/PEAR
 * @since      Class available since Release 0.1
 */
class PEAR_Command_Install extends PEAR_Command_Common
{
    // {{{ properties

    var $commands = array(
        'install' => array(
            'summary' => 'Install Package',
            'function' => 'doInstall',
            'shortcut' => 'i',
            'options' => array(
                'force' => array(
                    'shortopt' => 'f',
                    'doc' => 'will overwrite newer installed packages',
                    ),
                'loose' => array(
                    'shortopt' => 'l',
                    'doc' => 'do not check for recommended dependency version',
                    ),
                'nodeps' => array(
                    'shortopt' => 'n',
                    'doc' => 'ignore dependencies, install anyway',
                    ),
                'register-only' => array(
                    'shortopt' => 'r',
                    'doc' => 'do not install files, only register the package as installed',
                    ),
                'soft' => array(
                    'shortopt' => 's',
                    'doc' => 'soft install, fail silently, or upgrade if already installed',
                    ),
                'nobuild' => array(
                    'shortopt' => 'B',
                    'doc' => 'don\'t build C extensions',
                    ),
                'nocompress' => array(
                    'shortopt' => 'Z',
                    'doc' => 'request uncompressed files when downloading',
                    ),
                'installroot' => array(
                    'shortopt' => 'R',
                    'arg' => 'DIR',
                    'doc' => 'root directory used when installing files (ala PHP\'s INSTALL_ROOT), use packagingroot for RPM',
                    ),
                'packagingroot' => array(
                    'shortopt' => 'P',
                    'arg' => 'DIR',
                    'doc' => 'root directory used when packaging files, like RPM packaging',
                    ),
                'ignore-errors' => array(
                    'doc' => 'force install even if there were errors',
                    ),
                'alldeps' => array(
                    'shortopt' => 'a',
                    'doc' => 'install all required and optional dependencies',
                    ),
                'onlyreqdeps' => array(
                    'shortopt' => 'o',
                    'doc' => 'install all required dependencies',
                    ),
                'offline' => array(
                    'shortopt' => 'O',
                    'doc' => 'do not attempt to download any urls or contact channels',
                    ),
                'pretend' => array(
                    'shortopt' => 'p',
                    'doc' => 'Only list the packages that would be downloaded',
                    ),
                ),
            'doc' => '[channel/]<package> ...
Installs one or more PEAR packages.  You can specify a package to
install in four ways:

"Package-1.0.tgz" : installs from a local file

"http://example.com/Package-1.0.tgz" : installs from
anywhere on the net.

"package.xml" : installs the package described in
package.xml.  Useful for testing, or for wrapping a PEAR package in
another package manager such as RPM.

"Package[-version/state][.tar]" : queries your default channel\'s server
({config master_server}) and downloads the newest package with
the preferred quality/state ({config preferred_state}).

To retrieve Package version 1.1, use "Package-1.1," to retrieve
Package state beta, use "Package-beta."  To retrieve an uncompressed
file, append .tar (make sure there is no file by the same name first)

To download a package from another channel, prefix with the channel name like
"channel/Package"

More than one package may be specified at once.  It is ok to mix these
four ways of specifying packages.
'),
        'upgrade' => array(
            'summary' => 'Upgrade Package',
            'function' => 'doInstall',
            'shortcut' => 'up',
            'options' => array(
                'force' => array(
                    'shortopt' => 'f',
                    'doc' => 'overwrite newer installed packages',
                    ),
                'loose' => array(
                    'shortopt' => 'l',
                    'doc' => 'do not check for recommended dependency version',
                    ),
                'nodeps' => array(
                    'shortopt' => 'n',
                    'doc' => 'ignore dependencies, upgrade anyway',
                    ),
                'register-only' => array(
                    'shortopt' => 'r',
                    'doc' => 'do not install files, only register the package as upgraded',
                    ),
                'nobuild' => array(
                    'shortopt' => 'B',
                    'doc' => 'don\'t build C extensions',
                    ),
                'nocompress' => array(
                    'shortopt' => 'Z',
                    'doc' => 'request uncompressed files when downloading',
                    ),
                'installroot' => array(
                    'shortopt' => 'R',
                    'arg' => 'DIR',
                    'doc' => 'root directory used when installing files (ala PHP\'s INSTALL_ROOT), use packagingroot for RPM',
                    ),
                'packagingroot' => array(
                    'shortopt' => 'P',
                    'arg' => 'DIR',
                    'doc' => 'root directory used when packaging files, like RPM packaging',
                    ),
                'ignore-errors' => array(
                    'doc' => 'force install even if there were errors',
                    ),
                'alldeps' => array(
                    'shortopt' => 'a',
                    'doc' => 'install all required and optional dependencies',
                    ),
                'onlyreqdeps' => array(
                    'shortopt' => 'o',
                    'doc' => 'install all required dependencies',
                    ),
                'offline' => array(
                    'shortopt' => 'O',
                    'doc' => 'do not attempt to download any urls or contact channels',
                    ),
                'pretend' => array(
                    'shortopt' => 'p',
                    'doc' => 'Only list the packages that would be downloaded',
                    ),
                ),
            'doc' => '<package> ...
Upgrades one or more PEAR packages.  See documentation for the
"install" command for ways to specify a package.

When upgrading, your package will be updated if the provided new
package has a higher version number (use the -f option if you need to
upgrade anyway).

More than one package may be specified at once.
'),
        'upgrade-all' => array(
            'summary' => 'Upgrade All Packages',
            'function' => 'doInstall',
            'shortcut' => 'ua',
            'options' => array(
                'nodeps' => array(
                    'shortopt' => 'n',
                    'doc' => 'ignore dependencies, upgrade anyway',
                    ),
                'register-only' => array(
                    'shortopt' => 'r',
                    'doc' => 'do not install files, only register the package as upgraded',
                    ),
                'nobuild' => array(
                    'shortopt' => 'B',
                    'doc' => 'don\'t build C extensions',
                    ),
                'nocompress' => array(
                    'shortopt' => 'Z',
                    'doc' => 'request uncompressed files when downloading',
                    ),
                'installroot' => array(
                    'shortopt' => 'R',
                    'arg' => 'DIR',
                    'doc' => 'root directory used when installing files (ala PHP\'s INSTALL_ROOT), use packagingroot for RPM',
                    ),
                'ignore-errors' => array(
                    'doc' => 'force install even if there were errors',
                    ),
                'loose' => array(
                    'doc' => 'do not check for recommended dependency version',
                    ),
                ),
            'doc' => '
Upgrades all packages that have a newer release available.  Upgrades are
done only if there is a release available of the state specified in
"preferred_state" (currently {config preferred_state}), or a state considered
more stable.
'),
        'uninstall' => array(
            'summary' => 'Un-install Package',
            'function' => 'doUninstall',
            'shortcut' => 'un',
            'options' => array(
                'nodeps' => array(
                    'shortopt' => 'n',
                    'doc' => 'ignore dependencies, uninstall anyway',
                    ),
                'register-only' => array(
                    'shortopt' => 'r',
                    'doc' => 'do not remove files, only register the packages as not installed',
                    ),
                'installroot' => array(
                    'shortopt' => 'R',
                    'arg' => 'DIR',
                    'doc' => 'root directory used when installing files (ala PHP\'s INSTALL_ROOT)',
                    ),
                'ignore-errors' => array(
                    'doc' => 'force install even if there were errors',
                    ),
                'offline' => array(
                    'shortopt' => 'O',
                    'doc' => 'do not attempt to uninstall remotely',
                    ),
                ),
            'doc' => '[channel/]<package> ...
Uninstalls one or more PEAR packages.  More than one package may be
specified at once.  Prefix with channel name to uninstall from a
channel not in your default channel ({config default_channel})
'),
        'bundle' => array(
            'summary' => 'Unpacks a Pecl Package',
            'function' => 'doBundle',
            'shortcut' => 'bun',
            'options' => array(
                'destination' => array(
                   'shortopt' => 'd',
                    'arg' => 'DIR',
                    'doc' => 'Optional destination directory for unpacking (defaults to current path or "ext" if exists)',
                    ),
                'force' => array(
                    'shortopt' => 'f',
                    'doc' => 'Force the unpacking even if there were errors in the package',
                ),
            ),
            'doc' => '<package>
Unpacks a Pecl Package into the selected location. It will download the
package if needed.
'),
        'run-scripts' => array(
            'summary' => 'Run Post-Install Scripts bundled with a package',
            'function' => 'doRunScripts',
            'shortcut' => 'rs',
            'options' => array(
            ),
            'doc' => '<package>
Run post-installation scripts in package <package>, if any exist.
'),
    );

    // }}}
    // {{{ constructor

    /**
     * PEAR_Command_Install constructor.
     *
     * @access public
     */
    function PEAR_Command_Install(&$ui, &$config)
    {
        parent::PEAR_Command_Common($ui, $config);
    }

    // }}}

    /**
     * For unit testing purposes
     */
    function &getDownloader(&$ui, $options, &$config)
    {
        if (!class_exists('PEAR_Downloader')) {
            require_once 'PEAR/Downloader.php';
        }
        $a = &new PEAR_Downloader($ui, $options, $config);
        return $a;
    }

    /**
     * For unit testing purposes
     */
    function &getInstaller(&$ui)
    {
        if (!class_exists('PEAR_Installer')) {
            require_once 'PEAR/Installer.php';
        }
        $a = &new PEAR_Installer($ui);
        return $a;
    }

    function enableExtension($binaries, $type)
    {
        if (!($phpini = $this->config->get('php_ini', null, 'pear.php.net'))) {
            return PEAR::raiseError('configuration option "php_ini" is not set to php.ini location');
        }
        $ini = $this->_parseIni($phpini);
        if (PEAR::isError($ini)) {
            return $ini;
        }
        $fp = @fopen($phpini, 'wb');
        if (!$fp) {
            return PEAR::raiseError('cannot open php.ini "' . $phpini . '" for writing');
        }
        $line = 0;
        if ($type == 'extsrc' || $type == 'extbin') {
            $search = 'extensions';
            $enable = 'extension';
        } else {
            $search = 'zend_extensions';
            ob_start();
            phpinfo(INFO_GENERAL);
            $info = ob_get_contents();
            ob_end_clean();
            $debug = function_exists('leak') ? '_debug' : '';
            $ts = preg_match('Thread Safety.+enabled', $info) ? '_ts' : '';
            $enable = 'zend_extension' . $debug . $ts;
        }
        foreach ($ini[$search] as $line => $extension) {
            if (in_array($extension, $binaries, true) || in_array(
                  $ini['extension_dir'] . DIRECTORY_SEPARATOR . $extension, $binaries, true)) {
                // already enabled - assume if one is, all are
                return true;
            }
        }
        if ($line) {
            $newini = array_slice($ini['all'], 0, $line);
        } else {
            $newini = array();
        }
        foreach ($binaries as $binary) {
            if ($ini['extension_dir']) {
                $binary = basename($binary);
            }
            $newini[] = $enable . '="' . $binary . '"' . (OS_UNIX ? "\n" : "\r\n");
        }
        $newini = array_merge($newini, array_slice($ini['all'], $line));
        foreach ($newini as $line) {
            fwrite($fp, $line);
        }
        fclose($fp);
        return true;
    }

    function disableExtension($binaries, $type)
    {
        if (!($phpini = $this->config->get('php_ini', null, 'pear.php.net'))) {
            return PEAR::raiseError('configuration option "php_ini" is not set to php.ini location');
        }
        $ini = $this->_parseIni($phpini);
        if (PEAR::isError($ini)) {
            return $ini;
        }
        $line = 0;
        if ($type == 'extsrc' || $type == 'extbin') {
            $search = 'extensions';
            $enable = 'extension';
        } else {
            $search = 'zend_extensions';
            ob_start();
            phpinfo(INFO_GENERAL);
            $info = ob_get_contents();
            ob_end_clean();
            $debug = function_exists('leak') ? '_debug' : '';
            $ts = preg_match('Thread Safety.+enabled', $info) ? '_ts' : '';
            $enable = 'zend_extension' . $debug . $ts;
        }
        $found = false;
        foreach ($ini[$search] as $line => $extension) {
            if (in_array($extension, $binaries, true) || in_array(
                  $ini['extension_dir'] . DIRECTORY_SEPARATOR . $extension, $binaries, true)) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            // not enabled
            return true;
        }
        $fp = @fopen($phpini, 'wb');
        if (!$fp) {
            return PEAR::raiseError('cannot open php.ini "' . $phpini . '" for writing');
        }
        if ($line) {
            $newini = array_slice($ini['all'], 0, $line);
            // delete the enable line
            $newini = array_merge($newini, array_slice($ini['all'], $line + 1));
        } else {
            $newini = array_slice($ini['all'], 1);
        }
        foreach ($newini as $line) {
            fwrite($fp, $line);
        }
        fclose($fp);
        return true;
    }

    function _parseIni($filename)
    {
        if (file_exists($filename)) {
            if (filesize($filename) > 300000) {
                return PEAR::raiseError('php.ini "' . $filename . '" is too large, aborting');
            }
            ob_start();
            phpinfo(INFO_GENERAL);
            $info = ob_get_contents();
            ob_end_clean();
            $debug = function_exists('leak') ? '_debug' : '';
            $ts = preg_match('/Thread Safety.+enabled/', $info) ? '_ts' : '';
            $zend_extension_line = 'zend_extension' . $debug . $ts;
            $all = @file($filename);
            if (!$all) {
                return PEAR::raiseError('php.ini "' . $filename .'" could not be read');
            }
            $zend_extensions = $extensions = array();
            // assume this is right, but pull from the php.ini if it is found
            $extension_dir = ini_get('extension_dir');
            foreach ($all as $linenum => $line) {
                $line = trim($line);
                if (!$line) {
                    continue;
                }
                if ($line[0] == ';') {
                    continue;
                }
                if (strtolower(substr($line, 0, 13)) == 'extension_dir') {
                    $line = trim(substr($line, 13));
                    if ($line[0] == '=') {
                        $x = trim(substr($line, 1));
                        $x = explode(';', $x);
                        $extension_dir = str_replace('"', '', array_shift($x));
                        continue;
                    }
                }
                if (strtolower(substr($line, 0, 9)) == 'extension') {
                    $line = trim(substr($line, 9));
                    if ($line[0] == '=') {
                        $x = trim(substr($line, 1));
                        $x = explode(';', $x);
                        $extensions[$linenum] = str_replace('"', '', array_shift($x));
                        continue;
                    }
                }
                if (strtolower(substr($line, 0, strlen($zend_extension_line))) ==
                      $zend_extension_line) {
                    $line = trim(substr($line, strlen($zend_extension_line)));
                    if ($line[0] == '=') {
                        $x = trim(substr($line, 1));
                        $x = explode(';', $x);
                        $zend_extensions[$linenum] = str_replace('"', '', array_shift($x));
                        continue;
                    }
                }
            }
            return array(
                'extensions' => $extensions,
                'zend_extensions' => $zend_extensions,
                'extension_dir' => $extension_dir,
                'all' => $all,
            );
        } else {
            return PEAR::raiseError('php.ini "' . $filename . '" does not exist');
        }
    }

    // {{{ doInstall()

    function doInstall($command, $options, $params)
    {
        if (empty($this->installer)) {
            $this->installer = &$this->getInstaller($this->ui);
        }
        if ($command == 'upgrade') {
            $options['upgrade'] = true;
        }
        if (isset($options['installroot']) && isset($options['packagingroot'])) {
            return $this->raiseError('ERROR: cannot use both --installroot and --packagingroot');
        }
        if (isset($options['packagingroot']) && $this->config->get('verbose') > 2) {
            $this->ui->outputData('using package root: ' . $options['packagingroot']);
        }
        $reg = &$this->config->getRegistry();
        if ($command == 'upgrade-all') {
            $options['upgrade'] = true;
            $reg = &$this->config->getRegistry();
            $savechannel = $this->config->get('default_channel');
            $params = array();
            foreach ($reg->listChannels() as $channel) {
                if ($channel == '__uri') {
                    continue;
                }
                $this->config->set('default_channel', $channel);
                $chan = &$reg->getChannel($channel);
                if (PEAR::isError($chan)) {
                    return $this->raiseError($chan);
                }
                if ($chan->supportsREST($this->config->get('preferred_mirror')) &&
                      $base = $chan->getBaseURL('REST1.0', $this->config->get('preferred_mirror'))) {
                    $dorest = true;
                    unset($remote);
                } else {
                    $dorest = false;
                    $remote = &$this->config->getRemote($this->config);
                }
                $state = $this->config->get('preferred_state');
                $installed = array_flip($reg->listPackages($channel));
                PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
                if ($dorest) {
                    $rest = &$this->config->getREST('1.0', array());
                    $latest = $rest->listLatestUpgrades($base, $state, $installed, $channel, $reg);
                } else {
                    if (empty($state) || $state == 'any') {
                        $latest = $remote->call("package.listLatestReleases");
                    } else {
                        $latest = $remote->call("package.listLatestReleases", $state);
                    }
                }
                PEAR::staticPopErrorHandling();
                if (PEAR::isError($latest) || !is_array($latest)) {
                    continue;
                }
                foreach ($latest as $package => $info) {
                    $package = strtolower($package);
                    if (!isset($installed[$package])) {
                        // skip packages we don't have installed
                        continue;
                    }
                    $inst_version = $reg->packageInfo($package, 'version', $channel);
                    if (version_compare("$info[version]", "$inst_version", "le")) {
                        // installed version is up-to-date
                        continue;
                    }
                    $params[] = $reg->parsedPackageNameToString(array('package' => $package,
                        'channel' => $channel));
                    $this->ui->outputData(array('data' => "Will upgrade $package"), $command);
                }
            }
            $this->config->set('default_channel', $savechannel);
        }
        $this->downloader = &$this->getDownloader($this->ui, $options, $this->config);
        $errors = array();
        $downloaded = array();
        $downloaded = &$this->downloader->download($params);
        if (PEAR::isError($downloaded)) {
            return $this->raiseError($downloaded);
        }
        $errors = $this->downloader->getErrorMsgs();
        if (count($errors)) {
            foreach ($errors as $error) {
                $err['data'][] = array($error);
            }
            $err['headline'] = 'Install Errors';
            $this->ui->outputData($err);
            if (!count($downloaded)) {
                return $this->raiseError("$command failed");
            }
        }
        $data = array(
            'headline' => 'Packages that would be Installed'
        );
        if (isset($options['pretend'])) {
            foreach ($downloaded as $package) {
                $data['data'][] = array($reg->parsedPackageNameToString($package->getParsedPackage()));
            }
            $this->ui->outputData($data, 'pretend');
            return true;
        }
        $this->installer->setOptions($options);
        $this->installer->sortPackagesForInstall($downloaded);
        if (PEAR::isError($err = $this->installer->setDownloadedPackages($downloaded))) {
            $this->raiseError($err->getMessage());
            return true;
        }
        $extrainfo = array();
        if (isset($options['packagingroot'])) {
            $packrootphp_dir = $this->installer->_prependPath(
                $this->config->get('php_dir', null, 'pear.php.net'),
                $options['packagingroot']);
            $instreg = new PEAR_Registry($packrootphp_dir);
        } else {
            $instreg = $reg;
        }
        foreach ($downloaded as $param) {
            PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
            $info = $this->installer->install($param, $options);
            PEAR::staticPopErrorHandling();
            if (PEAR::isError($info)) {
                $oldinfo = $info;
                $pkg = &$param->getPackageFile();
                if ($info->getCode() != PEAR_INSTALLER_NOBINARY) {
                    if (!($info = $pkg->installBinary($this->installer))) {
                        $this->ui->outputData('ERROR: ' .$oldinfo->getMessage());
                        continue;
                    }
                    // we just installed a different package than requested,
                    // let's change the param and info so that the rest of this works
                    $param = $info[0];
                    $info = $info[1];
                }
            }
            if (is_array($info)) {
                if ($param->getPackageType() == 'extsrc' ||
                      $param->getPackageType() == 'extbin' ||
                      $param->getPackageType() == 'zendextsrc' ||
                      $param->getPackageType() == 'zendextbin') {
                    $pkg = &$param->getPackageFile();
                    if ($instbin = $pkg->getInstalledBinary()) {
                        $instpkg = &$instreg->getPackage($instbin, $pkg->getChannel());
                    } else {
                        $instpkg = &$instreg->getPackage($pkg->getPackage(), $pkg->getChannel());
                    }
                    foreach ($instpkg->getFilelist() as $name => $atts) {
                        $pinfo = pathinfo($atts['installed_as']);
                        if (!isset($pinfo['extension']) ||
                              in_array($pinfo['extension'], array('c', 'h'))) {
                            continue; // make sure we don't match php_blah.h
                        }
                        if ((strpos($pinfo['basename'], 'php_') === 0 &&
                              $pinfo['extension'] == 'dll') ||
                              // most unices
                              $pinfo['extension'] == 'so' ||
                              // hp-ux
                              $pinfo['extension'] == 'sl') {
                            $binaries[] = array($atts['installed_as'], $pinfo);
                            break;
                        }
                    }
                    foreach ($binaries as $pinfo) {
                        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
                        $ret = $this->enableExtension(array($pinfo[0]), $param->getPackageType());
                        PEAR::staticPopErrorHandling();
                        if (PEAR::isError($ret)) {
                            $extrainfo[] = $ret->getMessage();
                            if ($param->getPackageType() == 'extsrc' ||
                                  $param->getPackageType() == 'extbin') {
                                $exttype = 'extension';
                            } else {
                                ob_start();
                                phpinfo(INFO_GENERAL);
                                $info = ob_get_contents();
                                ob_end_clean();
                                $debug = function_exists('leak') ? '_debug' : '';
                                $ts = preg_match('Thread Safety.+enabled', $info) ? '_ts' : '';
                                $exttype = 'zend_extension' . $debug . $ts;
                            }
                            $extrainfo[] = 'You should add "' . $exttype . '=' .
                                $pinfo[1]['basename'] . '" to php.ini';
                        } else {
                            $extrainfo[] = 'Extension ' . $instpkg->getProvidesExtension() .
                                ' enabled in php.ini';
                        }
                    }
                }
                if ($this->config->get('verbose') > 0) {
                    $channel = $param->getChannel();
                    $label = $reg->parsedPackageNameToString(
                        array(
                            'channel' => $channel,
                            'package' => $param->getPackage(),
                            'version' => $param->getVersion(),
                        ));
                    $out = array('data' => "$command ok: $label");
                    if (isset($info['release_warnings'])) {
                        $out['release_warnings'] = $info['release_warnings'];
                    }
                    $this->ui->outputData($out, $command);
                    if (!isset($options['register-only']) && !isset($options['offline'])) {
                        if ($this->config->isDefinedLayer('ftp')) {
                            PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
                            $info = $this->installer->ftpInstall($param);
                            PEAR::staticPopErrorHandling();
                            if (PEAR::isError($info)) {
                                $this->ui->outputData($info->getMessage());
                                $this->ui->outputData("remote install failed: $label");
                            } else {
                                $this->ui->outputData("remote install ok: $label");
                            }
                        }
                    }
                }
                $deps = $param->getDeps();
                if ($deps) {
                    if (isset($deps['group'])) {
                        $groups = $deps['group'];
                        if (!isset($groups[0])) {
                            $groups = array($groups);
                        }
                        foreach ($groups as $group) {
                            if ($group['attribs']['name'] == 'default') {
                                // default group is always installed, unless the user
                                // explicitly chooses to install another group
                                continue;
                            }
                            $this->ui->outputData($param->getPackage() . ': Optional feature ' .
                                $group['attribs']['name'] . ' available (' .
                                $group['attribs']['hint'] . ')');
                        }
                        $extrainfo[] = 'To install use "pear install ' .
                            $reg->parsedPackageNameToString(
                                array('package' => $param->getPackage(),
                                      'channel' => $param->getChannel()), true) .
                                  '#featurename"';
                    }
                }
                if (isset($options['installroot'])) {
                    $reg = &$this->config->getRegistry();
                }
                if (isset($options['packagingroot'])) {
                    $instreg = new PEAR_Registry($packrootphp_dir);
                } else {
                    $instreg = $reg;
                }
                $pkg = &$instreg->getPackage($param->getPackage(), $param->getChannel());
                // $pkg may be NULL if install is a 'fake' install via --packagingroot
                if (is_object($pkg)) {
                    $pkg->setConfig($this->config);
                    if ($list = $pkg->listPostinstallScripts()) {
                        $pn = $reg->parsedPackageNameToString(array('channel' =>
                           $param->getChannel(), 'package' => $param->getPackage()), true);
                        $extrainfo[] = $pn . ' has post-install scripts:';
                        foreach ($list as $file) {
                            $extrainfo[] = $file;
                        }
                        $extrainfo[] = 'Use "pear run-scripts ' . $pn . '" to run';
                        $extrainfo[] = 'DO NOT RUN SCRIPTS FROM UNTRUSTED SOURCES';
                    }
                }
            } else {
                return $this->raiseError("$command failed");
            }
        }
        if (count($extrainfo)) {
            foreach ($extrainfo as $info) {
                $this->ui->outputData($info);
            }
        }
        return true;
    }

    // }}}
    // {{{ doUninstall()

    function doUninstall($command, $options, $params)
    {
        if (empty($this->installer)) {
            $this->installer = &$this->getInstaller($this->ui);
        }
        if (isset($options['remoteconfig'])) {
            $e = $this->config->readFTPConfigFile($options['remoteconfig']);
            if (!PEAR::isError($e)) {
                $this->installer->setConfig($this->config);
            }
        }
        if (sizeof($params) < 1) {
            return $this->raiseError("Please supply the package(s) you want to uninstall");
        }
        $reg = &$this->config->getRegistry();
        $newparams = array();
        $badparams = array();
        foreach ($params as $pkg) {
            $channel = $this->config->get('default_channel');
            PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
            $parsed = $reg->parsePackageName($pkg, $channel);
            PEAR::staticPopErrorHandling();
            if (!$parsed || PEAR::isError($parsed)) {
                $badparams[] = $pkg;
                continue;
            }
            $package = $parsed['package'];
            $channel = $parsed['channel'];
            $info = &$reg->getPackage($package, $channel);
            if ($info === null &&
                 ($channel == 'pear.php.net' || $channel == 'pecl.php.net')) {
                // make sure this isn't a package that has flipped from pear to pecl but
                // used a package.xml 1.0
                $testc = ($channel == 'pear.php.net') ? 'pecl.php.net' : 'pear.php.net';
                $info = &$reg->getPackage($package, $testc);
                if ($info !== null) {
                    $channel = $testc;
                }
            }
            if ($info === null) {
                $badparams[] = $pkg;
            } else {
                $newparams[] = &$info;
                // check for binary packages (this is an alias for those packages if so)
                if ($installedbinary = $info->getInstalledBinary()) {
                    $this->ui->log('adding binary package ' .
                        $reg->parsedPackageNameToString(array('channel' => $channel,
                            'package' => $installedbinary), true));
                    $newparams[] = &$reg->getPackage($installedbinary, $channel);
                }
                // add the contents of a dependency group to the list of installed packages
                if (isset($parsed['group'])) {
                    $group = $info->getDependencyGroup($parsed['group']);
                    if ($group) {
                        $installed = &$reg->getInstalledGroup($group);
                        if ($installed) {
                            foreach ($installed as $i => $p) {
                                $newparams[] = &$installed[$i];
                            }
                        }
                    }
                }
            }
        }
        $err = $this->installer->sortPackagesForUninstall($newparams);
        if (PEAR::isError($err)) {
            $this->ui->outputData($err->getMessage(), $command);
            return true;
        }
        $params = $newparams;
        // twist this to use it to check on whether dependent packages are also being uninstalled
        // for circular dependencies like subpackages
        $this->installer->setUninstallPackages($newparams);
        $params = array_merge($params, $badparams);
        foreach ($params as $pkg) {
            $this->installer->pushErrorHandling(PEAR_ERROR_RETURN);
            if ($err = $this->installer->uninstall($pkg, $options)) {
                $this->installer->popErrorHandling();
                if (PEAR::isError($err)) {
                    $this->ui->outputData($err->getMessage(), $command);
                    continue;
                }
                if ($pkg->getPackageType() == 'extsrc' ||
                      $pkg->getPackageType() == 'extbin' ||
                      $pkg->getPackageType() == 'zendextsrc' ||
                      $pkg->getPackageType() == 'zendextbin') {
                    if ($instbin = $pkg->getInstalledBinary()) {
                        continue; // this will be uninstalled later
                    }
                    foreach ($pkg->getFilelist() as $name => $atts) {
                        $pinfo = pathinfo($atts['installed_as']);
                        if (!isset($pinfo['extension']) ||
                              in_array($pinfo['extension'], array('c', 'h'))) {
                            continue; // make sure we don't match php_blah.h
                        }
                        if ((strpos($pinfo['basename'], 'php_') === 0 &&
                              $pinfo['extension'] == 'dll') ||
                              // most unices
                              $pinfo['extension'] == 'so' ||
                              // hp-ux
                              $pinfo['extension'] == 'sl') {
                            $binaries[] = array($atts['installed_as'], $pinfo);
                            break;
                        }
                    }
                    foreach ($binaries as $pinfo) {
                        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
                        $ret = $this->disableExtension(array($pinfo[0]), $pkg->getPackageType());
                        PEAR::staticPopErrorHandling();
                        if (PEAR::isError($ret)) {
                            $extrainfo[] = $ret->getMessage();
                            if ($pkg->getPackageType() == 'extsrc' ||
                                  $pkg->getPackageType() == 'extbin') {
                                $exttype = 'extension';
                            } else {
                                ob_start();
                                phpinfo(INFO_GENERAL);
                                $info = ob_get_contents();
                                ob_end_clean();
                                $debug = function_exists('leak') ? '_debug' : '';
                                $ts = preg_match('Thread Safety.+enabled', $info) ? '_ts' : '';
                                $exttype = 'zend_extension' . $debug . $ts;
                            }
                            $this->ui->outputData('Unable to remove "' . $exttype . '=' .
                                $pinfo[1]['basename'] . '" from php.ini', $command);
                        } else {
                            $this->ui->outputData('Extension ' . $pkg->getProvidesExtension() .
                                ' disabled in php.ini', $command);
                        }
                    }
                }
                $savepkg = $pkg;
                if ($this->config->get('verbose') > 0) {
                    if (is_object($pkg)) {
                        $pkg = $reg->parsedPackageNameToString($pkg);
                    }
                    $this->ui->outputData("uninstall ok: $pkg", $command);
                }
                if (!isset($options['offline']) && is_object($savepkg) &&
                      defined('PEAR_REMOTEINSTALL_OK')) {
                    if ($this->config->isDefinedLayer('ftp')) {
                        $this->installer->pushErrorHandling(PEAR_ERROR_RETURN);
                        $info = $this->installer->ftpUninstall($savepkg);
                        $this->installer->popErrorHandling();
                        if (PEAR::isError($info)) {
                            $this->ui->outputData($info->getMessage());
                            $this->ui->outputData("remote uninstall failed: $pkg");
                        } else {
                            $this->ui->outputData("remote uninstall ok: $pkg");
                        }
                    }
                }
            } else {
                $this->installer->popErrorHandling();
                if (is_object($pkg)) {
                    $pkg = $reg->parsedPackageNameToString($pkg);
                }
                return $this->raiseError("uninstall failed: $pkg");
            }
        }
        return true;
    }

    // }}}


    // }}}
    // {{{ doBundle()
    /*
    (cox) It just downloads and untars the package, does not do
            any check that the PEAR_Installer::_installFile() does.
    */

    function doBundle($command, $options, $params)
    {
        $downloader = &$this->getDownloader($this->ui, array('force' => true, 'nodeps' => true,
            'soft' => true, 'downloadonly' => true), $this->config);
        $reg = &$this->config->getRegistry();
        if (sizeof($params) < 1) {
            return $this->raiseError("Please supply the package you want to bundle");
        }

        if (isset($options['destination'])) {
            if (!is_dir($options['destination'])) {
                System::mkdir('-p ' . $options['destination']);
            }
            $dest = realpath($options['destination']);
        } else {
            $pwd = getcwd();
            if (is_dir($pwd . DIRECTORY_SEPARATOR . 'ext')) {
                $dest = $pwd . DIRECTORY_SEPARATOR . 'ext';
            } else {
                $dest = $pwd;
            }
        }
        $downloader->setDownloadDir($dest);
        $result = &$downloader->download(array($params[0]));
        if (PEAR::isError($result)) {
            return $result;
        }
        $pkgfile = &$result[0]->getPackageFile();
        $pkgname = $pkgfile->getName();
        $pkgversion = $pkgfile->getVersion();

        // Unpacking -------------------------------------------------
        $dest .= DIRECTORY_SEPARATOR . $pkgname;
        $orig = $pkgname . '-' . $pkgversion;

        $tar = &new Archive_Tar($pkgfile->getArchiveFile());
        if (!$tar->extractModify($dest, $orig)) {
            return $this->raiseError('unable to unpack ' . $pkgfile->getArchiveFile());
        }
        $this->ui->outputData("Package ready at '$dest'");
    // }}}
    }

    // }}}

    function doRunScripts($command, $options, $params)
    {
        if (!isset($params[0])) {
            return $this->raiseError('run-scripts expects 1 parameter: a package name');
        }
        $reg = &$this->config->getRegistry();
        PEAR::staticPushErrorHandling(PEAR_ERROR_RETURN);
        $parsed = $reg->parsePackageName($params[0], $this->config->get('default_channel'));
        PEAR::staticPopErrorHandling();
        if (PEAR::isError($parsed)) {
            return $this->raiseError($parsed);
        }
        $package = &$reg->getPackage($parsed['package'], $parsed['channel']);
        if (is_object($package)) {
            $package->setConfig($this->config);
            $package->runPostinstallScripts();
        } else {
            return $this->raiseError('Could not retrieve package "' . $params[0] . '" from registry');
        }
        $this->ui->outputData('Install scripts complete', $command);
        return true;
    }
}
?>
