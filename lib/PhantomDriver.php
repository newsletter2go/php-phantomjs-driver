<?php

namespace NielsHoppe\PhantomJS;

/**
 *
 */

class PhantomDriver {

    private $pipes;
    private $process;
    private $running;

    function __construct () {

        $this->process = new PhantomProcess();
    }

    public function start ($script) {

        $this->process->start($script);
    }

    public function stop () {

        return $this->process->stop();
    }

    public function request ($command, $args = array()) {

        $message = sprintf('%s %s', $command, implode(' ', $args));
        $result = $this->process->send($message);

        return $result;
    }
}
