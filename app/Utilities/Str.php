<?php

namespace App\Utilities;

class Str {
    public static function preview(string $original, int $max_length = 60, string $ellipsis = ' ...'): string {
        $preview = $original;

        if ($max_length < strlen($preview)) {
            $preview_chopped_length = $max_length - strlen($ellipsis);
            // one additional character such that a whole word is not dropped
            $preview = substr($preview, 0, $preview_chopped_length + 1);
            $last_space = strrpos($preview, ' ');

            if ($last_space !== false) {
                $preview = substr($preview, 0, $last_space);
            }

            $preview .= $ellipsis;
        }

        return $preview;
    }
}
