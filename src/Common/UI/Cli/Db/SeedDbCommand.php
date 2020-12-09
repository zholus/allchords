<?php
declare(strict_types=1);

namespace App\Common\UI\Cli\Db;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class SeedDbCommand extends Command
{
    protected static $defaultName = 'db:seed';
    private ParameterBagInterface $parameterBag;
    private Connection $connection;

    public function __construct(ParameterBagInterface $parameterBag, Connection $connection)
    {
        parent::__construct();
        $this->parameterBag = $parameterBag;
        $this->connection = $connection;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $fixturesSqlPath = $this->parameterBag->get('database_fixtures_sql');

        if (!is_file($fixturesSqlPath)) {
            throw new \RuntimeException('Fixtures sql file not found, path: ' . $fixturesSqlPath);
        }

        $fixturesSql = file_get_contents($fixturesSqlPath);

        $this->connection->exec($fixturesSql);

        $io->success('Seeding has been finished');

        return self::SUCCESS;
    }
}
