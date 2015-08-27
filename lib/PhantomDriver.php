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

        $this->process->start();
    }

    public function stop () {

        return $this->process->stop();
    }

    public function process ($url) {

        $result = $this->process->send($url);

        return $result;
    }

    /**
     * convenience method; not intended for public use
     * @deprecated
     */

    public function screenshot ($inFile, $outFile) {

        $imageBase64 = $this->process("$inFile\n");
        $image = base64_decode($imageBase64);

        file_put_contents($outFile, $image);
    }
}
