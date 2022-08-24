<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class MigrateFreshCommand extends Command
{
    use ConfirmableTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'degustabox:migrate:fresh
                            {--database= : The database connection to use}
                            {--drop-views : Drop all tables and views}
                            {--drop-types : Drop all tables and types (Postgres only)}
                            {--force : Force the operation to run when in production}
                            {--path=* : The path(s) to the migrations files to be executed}
                            {--realpath= : Indicate any provided migration file paths are pre-resolved absolute paths}
                            {--schema-path= : The path to a schema dump file}
                            {--seed : Indicates if the seed task should be re-run}
                            {--seeder= : The class name of the root seeder}
                            {--step : Force the migrations to be run so they can be rolled back individually}';

    public function handle(): int
    {
        if (!$this->confirmToProceed()) {
            return 1;
        }

        $this->wipe();
        $this->migrate();
        $this->seed();

        return 0;
    }

    protected function needsSeeding(): bool
    {
        return $this->option('seed') || $this->option('seeder');
    }

    protected function getOptions(): array
    {
        return parent::getOptions();
    }

    private function wipe(): void
    {
        $this->call('db:wipe', array_filter([
            '--database'   => $this->input->getOption('database'),
            '--drop-views' => $this->input->getOption('drop-views'),
            '--drop-types' => $this->input->getOption('drop-types'),
            '--force'      => true,
        ]));
    }

    private function migrate(): void
    {
        $this->call('migrate', array_filter([
            '--database'    => $this->input->getOption('database'),
            '--path'        => $this->input->getOption('path'),
            '--realpath'    => $this->input->getOption('realpath'),
            '--schema-path' => $this->input->getOption('schema-path'),
            '--force'       => true,
            '--step'        => $this->option('step'),
        ]));
    }

    private function seed(): void
    {
        if ($this->needsSeeding()) {
            $this->call('db:seed', array_filter([
                '--database' => $this->input->getOption('database'),
                '--class'    => $this->option('seeder') ?: 'Database\\Seeders\\DatabaseSeeder',
                '--force'    => true,
            ]));
        }
    }
}
