<?php

declare(strict_types=1);

// Fails unless a Cobertura report shows every branch executed: health maths must have
// 100% branch coverage (RULES §7, ADR 0007). Usage: php scripts/assert-full-branch-coverage.php <report.xml>

$report = $argv[1] ?? 'build/health-coverage.xml';
$coverage = is_file($report) ? simplexml_load_file($report) : false;

if ($coverage === false) {
    fwrite(STDERR, "No coverage report at {$report}. It needs Xdebug: XDEBUG_MODE=coverage composer test:health\n");
    exit(1);
}

$valid = (int) $coverage['branches-valid'];
$covered = (int) $coverage['branches-covered'];

if ($valid === 0 || $covered < $valid) {
    fwrite(STDERR, "Health maths branch coverage is {$covered}/{$valid}: every branch needs a test (RULES §7).\n");
    exit(1);
}

echo "Health maths branch coverage: {$covered}/{$valid} branches (100%).\n";
