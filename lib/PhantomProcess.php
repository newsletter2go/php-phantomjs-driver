<?php

namespace NielsHoppe\PhantomJS;

/**
 *
 */

class PhantomProcess {

    private $pipes;
    private $process;
    private $running;
    private $command;

    function __construct () {

        $this->running = false;
        $this->command = 'phantomjs'; // which phantomjs
    }

    public function start ($script) {

        if (!file_exists($script)) {

            throw new \Exception('No such file: ' . $script);
        }

        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "r")
        );

        $command = $this->command . ' ' . $script;

        $this->process = proc_open($command, $descriptorspec, $this->pipes);
        $this->running = true;
    }

    public function stop () {

        $this->running = false;

        fclose($this->pipes[0]);
        fclose($this->pipes[1]);
        fclose($this->pipes[2]);

        // It is important that you close any pipes before calling
        // proc_close in order to avoid a deadlock

        $return_value = proc_close($this->process);

        return $return_value;
    }

    public function send ($message) {

        if (!$this->running) {

            throw new \Exception('Process not running.');
        }

        // send URL to PhantomJS process
        if (fwrite($this->pipes[0], "$message\n") === false) {

            throw new \Exception('Message not sent for unknown reason.');
        }

        // read back result from PhantomJS process
        $result = fgets($this->pipes[1]);

        // read back error from PhantomJS process
        $error = fgets($this->pipes[2]);

        if ($error) {

            throw new \Exception($error);
        }

        return $result;
    }
}
