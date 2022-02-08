<?php
/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file is part of the Async2 Framework package.
 * (c) Petru Szemereczki <petru.office92@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace async2\component\file;

use async2\util\stream\php_stream;

use function file_exists;
use function file_get_contents;
use function is_string;

/**
 * @package async2
 *
 * this class handles the opening, closing, reading and writing a file.
 * with all php quirks taken care of.
 */
final class file
{
    /**
     * performs a safe file_get_contents() on a given path.
     *
     * disclaimer: don't use from now the php_stream enum! it's only temporary here.
     */
    public static function read_contents(php_stream|string $path): string
    {
        $path = !is_string($path) ? $path->value : $path;

        $contents = file_get_contents(filename: $path);

        if (false === $contents) {
            throw file_exception::unreadable($path);
        }

        return $contents;
    }

    /**
     * checks whether the file exists or not.
     */
    public static function exists(string $file): bool
    {
        return file_exists($file);
    }
}
