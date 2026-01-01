<?php

namespace tebe;

define('INFO_OUTPUT_TEXT', 1);
define('INFO_OUTPUT_JSON', 2);

/**
 * @param int $flags
 * @param int|NULL $outputFlags
 * @return bool
 */
function phpinfo($flags = INFO_ALL, $outputFlags = NULL)
{
    if (php_sapi_name() !== 'cli') {
        \phpinfo($flags);

        return true;
    }

    if ($outputFlags === NULL) {
        $outputFlags = INFO_OUTPUT_TEXT;
    }

    if ($outputFlags === INFO_OUTPUT_TEXT) {
        ob_start();
        \phpinfo($flags);
        $output = ob_get_clean();

        $output = str_replace("\n\n\n", "\n\n", $output);

        $data = [];
        $emptyLine = false;

        foreach (explode("\n", $output) as $line) {
            $trimmedLine = trim($line);

            if (strlen($trimmedLine) === 0) {
                $data[] = '';
                $emptyLine = true;
            } elseif ($trimmedLine === 'Directive => Local Value => Master Value') {
                if ($emptyLine === false) {
                    $data[] = '';
                }
                $data[] = $line;
                $emptyLine = false;
            } elseif ($trimmedLine === 'PHP License') {
                $data[] = $line;
                $data[] = '';
                $emptyLine = false;
            } else {
                $data[] = $line;
                $emptyLine = false;
            }
        }

        echo join("\n", $data);

        return true;
    }

    if ($outputFlags === INFO_OUTPUT_JSON) {
        ob_start();
        \phpinfo($flags);
        $output = ob_get_clean();

        $data = [];
        $i = 0;
        $inDirectives = false;

        $lines = explode("\n", $output);

        foreach ($lines as $line) {
            $line = trim($line);

            if (strlen($line) === 0) {
                $inDirectives = false;
                continue;
            }

            if ($line === 'Variable => Value') {
                break;
            } // Stop once we reach variables

            $matches = [];
            if (preg_match('@^[a-z0-9()]+$@i', $line, $matches)) {
                $i++;
                $data[$i] = [
                    'name' => $matches[0],
                    'values' => [],
                    'directives' => [],
                    'text' => [],
                ];
            } elseif ($line == 'Directive => Local Value => Master Value') {
                $inDirectives = true;
            } elseif (strpos($line, ' => ') > 0) {
                $pieces = explode(' => ', $line);
                if ($inDirectives) {
                    $data[$i]['directives'][] = ['directive' => $pieces[0], 'local_value' => $pieces[1], 'master_value' => $pieces[2]];
                } else {
                    $data[$i]['values'][] = ['key' => $pieces[0], 'value' => $pieces[1]];
                }
            } else {
                $data[$i]['text'][] = $line;
            }
        }

        echo json_encode(array_values($data), JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

        return true;
    }

    return true;
}
