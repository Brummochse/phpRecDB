<?php

class FileSizeFormatter
{
    /**
     * Formats a file size in MB into a human-readable string with a maximum of 3 digits.
     *
     * The method converts the file size from MB into the appropriate unit (MB, GB, TB)
     * and dynamically adjusts the number of decimal places to ensure that the resulting
     * string contains no more than 3 digits (e.g., "1.00 GB", "12.3 GB", "79 MB").
     */
    public static function format(int $fileSizeInMB): string
    {
        $units = ['MB', 'GB', 'TB'];
        $unitIndex = 0;

        while ($fileSizeInMB >= 1024 && $unitIndex < count($units) - 1) {
            $fileSizeInMB /= 1024;
            $unitIndex++;
        }

        $decimals = $fileSizeInMB < 10 ? 2 : ($fileSizeInMB < 100 ? 1 : 0);

        return number_format($fileSizeInMB, $decimals, ',', '') . ' ' . $units[$unitIndex];
    }

}