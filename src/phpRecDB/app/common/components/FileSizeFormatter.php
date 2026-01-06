<?php

class FileSizeFormatter
{

    private const PATTERN = '/^(\d+(?:[,\.]\d+)?)\s*(MB|GB|TB)$/i';


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
            $fileSizeInMB /= 1024.0;
            $unitIndex++;
        }

        $decimals = $fileSizeInMB < 10 ? 2 : ($fileSizeInMB < 100 ? 1 : 0);
        $fileSizeInMB = floor($fileSizeInMB * 100) / 100;
        return number_format($fileSizeInMB, $decimals, ',', '') . ' ' . $units[$unitIndex];
    }


    public static function isValid(string $input): bool
    {
        return preg_match(self::PATTERN, trim($input)) === 1;
    }

    public static function normalizeToMb(string $value): int|null
    {
        $value = trim($value);

        if (!preg_match(self::PATTERN, $value, $matches)) {
            throw new UnexpectedValueException("Invalid file size format: $value");
        }

        $number = (float) str_replace(',', '.', $matches[1]);
        $unit   = strtoupper($matches[2]);

        $mb = match ($unit) {
            'TB' => $number * 1024 * 1024,
            'GB' => $number * 1024,
            default => $number,
        };

        return (int) ceil($mb);
    }

}