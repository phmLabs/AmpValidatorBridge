<?php

namespace phmLabs\AmpValidatorBridge;

class AmpValidator
{
    public function validate($htmlContent)
    {
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5(microtime()) . '.html';
        file_put_contents($file, $htmlContent);

        $command = 'node ' . __DIR__ . '/../validator/amp.js ' . $file . ' 2>&1';
        exec($command, $plainOutoput, $return);
        unlink($file);

        $output = implode("\n", $plainOutoput);

        if (strpos($output, "Cannot find module 'amphtml-validator'") !== false) {
            throw new \RuntimeException('Unable to start amphtml-validator. Please run "npm install" in directory ' . realpath(__DIR__ . '/../validator/'));
        }

        $failures = json_decode($output, true);

        if (!$failures) {
            return [];
        } else {
            return $failures;
        }
    }
}
