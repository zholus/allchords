<?php
declare(strict_types=1);

namespace App\Common\UI\Cli\Db;

use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class RefreshCommand extends Command
{
    protected static $defaultName = 'db:refresh';
    private Connection $connection;
    private ParameterBagInterface $parameterBag;

    public function __construct(Connection $connection, ParameterBagInterface $parameterBag)
    {
        parent::__construct();

        $this->connection = $connection;
        $this->parameterBag = $parameterBag;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $tablesList = $this->getTablesList();

        $this->dropTables($tablesList);

        $this->migrate($output);

        $this->seedDb($output);

        return self::SUCCESS;
    }

    private function getTablesList(): array
    {
        $sql = "
            SELECT table_name as table_name FROM information_schema.tables
                WHERE table_schema = :DATABASE_NAME;
        ";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':DATABASE_NAME', $this->parameterBag->get('database_name'));

        $statement->execute();

        $result = [];

        foreach ($statement->fetchAllAssociative() as $row) {
            $result[] = $row['table_name'];
        }

        return $result;
    }

    private function dropTables(array $tablesList): void
    {
        $this->connection->exec("SET foreign_key_checks = 0");

        foreach ($tablesList as $tableName) {
            $sql = sprintf(
                'DROP TABLE %s',
                $tableName
            );

            $this->connection->exec($sql);
        }

        $this->connection->exec("SET foreign_key_checks = 1");
    }

    private function migrate(OutputInterface $output): void
    {
        $command = $this->getApplication()->find('doctrine:migrations:migrate');

        $command->run(new ArrayInput([]), $output);
    }

    private function seedDb(OutputInterface $output)
    {
        $command = $this->getApplication()->find('db:seed');

        $command->run(new ArrayInput([]), $output);
    }
}
