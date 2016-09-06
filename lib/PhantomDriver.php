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

    /**
     * @deprecated
     */

    public function process ($url) {

        $result = $this->process->send($url);

        return $result;
    }

    public function request ($command, $args) {

        $message = sprintf('%s %s', $command, implode(' ', $args));
        $result = $this->process->send($message);

        return $result;
    }

    /**
     * convenience method; not intended for public use
     * @deprecated
     */

    public function screenshot ($inFile, $outFile) {

        $imageBase64 = $this->process($inFile);
        $image = base64_decode($imageBase64);

        file_put_contents($outFile, $image);
    }
}
