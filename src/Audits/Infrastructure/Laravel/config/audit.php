<?php

return [
    'generate_audits' => filter_var(env('GENERATE_AUDITS', true), FILTER_VALIDATE_BOOL),
];
