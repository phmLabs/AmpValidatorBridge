<?php

namespace phmLabs\AmpValidatorBridge;

class AmpValidator
{
    public function validate($htmlContent)
    {
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . md5(microtime()) . '.html';
        file_put_contents($file, $htmlContent);

        $command = 'node ' . __DIR__ . '/../validator/amp.js ' . $file;
        exec($command, $output, $return);
        unlink($file);

        $failures = json_decode($output[0], true);

        if (!$failures) {
            return [];
        } else {
            return $failures;
        }
    }
}
