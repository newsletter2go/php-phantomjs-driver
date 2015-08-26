<?php

//namespace HielsNoppe\PhantomJS;

/**
 *
 */

class PhantomDriver {

    private $pipes;
    private $process;
    private $running;

    function __construct () {

        $this->running = false;
    }

    public function process ($url) {

        if (!$this->running) {

            // TODO: Throw an exception
            return;
        }

        // send URL to PhantomJS process
        fwrite($this->pipes[0], "$url\n");

        // read back result from PhantomJS process
        $result = fgets($this->pipes[1]);

        return $result;
    }

    /**
     * convenience method; not intended for public use
     * @deprecated
     */

    public function screenshot ($inFile, $outFile) {

        if (!$this->running) {

            // TODO: Throw an exception
            return;
        }

        fwrite($this->pipes[0], "$inFile\n");

        $imageBase64 = fgets($this->pipes[1]);
        $image = base64_decode($imageBase64);

        file_put_contents($outFile, $image);
    }

    public function start ($script) {

        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("file", "/tmp/error-output.txt", "a")
        );

        $command = 'phantomjs ' . $script;

        $this->process = proc_open($command, $descriptorspec, $this->pipes);
        $this->running = true;
    }

    public function stop () {

        $this->running = false;

        fclose($this->pipes[0]);
        fclose($this->pipes[1]);

        // It is important that you close any pipes before calling
        // proc_close in order to avoid a deadlock

        $return_value = proc_close($this->process);

        return $return_value;
    }
}
