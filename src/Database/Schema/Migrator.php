<?php declare(strict_types=1);

namespace Feather\Database\Schema;

use Feather\Core\FeatherDi;
use Feather\Database\Exceptions\DatabaseException;
use Feather\Database\Query;
use Feather\Database\Schema\Column\ColumnInterface;

class Migrator
{
    private FeatherDi $di;
    private Query $query;
    private array $tables;
    private bool $allowDelete = false;

    public function __construct(
        FeatherDi $di,
        Query $query
    ) {
        $this->di = $di;
        $this->query = $query;
    }

    /**
     * Register a table for database migrator
     *
     * @throws DatabaseException
     */
    public function registerTable(string $tableClass)
    {
        $table = $this->di->get($tableClass);

        if (!$table instanceof TableInterface) {
            throw new DatabaseException(
                \sprintf('Invalid table %s', $tableClass)
            );
        }

        $this->tables[] = $table;
    }

    public function setAllowDelete(bool $allow): Migrator 
    {
        $this->allowDelete = $allow;

        return $this;
    }

    /**
     * Execute the database migration
     *
     * @throws DatabaseException
     */
    public function migrate()
    {
        /**
         * Operations done in the database migration, order matters!
         * 1. Create tables which do not exist
         * 2. Add new columns and alter existing ones
         * 3. Remove columns which are not in the definition
         * 4. Remove tables which are not defined (TODO)
         * 5. Add primary keys to tables (TODO)
         * 6. Add/alter indexes to tables (TODO)
         * 7. Remove indexes which are not defined (TODO)
         * 8. Add/alter foreign keys to tables (TODO)
         * 9. Remove foreign keys which are not defined (TODO)
         *
         * TODO: Data transfer migrations, for example moving data from
         * column to another.
         */
        try {
            /** @var Table $table */
            foreach ($this->tables as $table)
            {
                $this->query->execute(
                    $this->getCreateTableQuery($table)
                );

                foreach ($this->getAlterTableQueries($table) as $query) {
                    $this->query->execute($query);
                }

                if ($this->allowDelete) {
                    foreach ($this->getRemoveColumnsQueries($table) as $query) {
                        $this->query->execute($query);
                    }
                }
            }
        } catch (\Exception $e) {
            throw new DatabaseException(
                \sprintf('Migration error: %s', $e->getMessage())
            );
        }
    }

    /**
     * Get query for table creation
     *
     * @throws DatabaseException
     */
    private function getCreateTableQuery(Table $table)
    {
        $columns = [];

        foreach ($table->getSchema() as $name => $column) {
            if (!$column instanceof ColumnInterface) {
                throw new DatabaseException('Invalid column ' . $name);
            }

            $columns[] = \sprintf(
                '%s %s',
                $name,
                $column->getDefinition()
            );
        }

        return \sprintf(
            'CREATE TABLE if not exists %s (%s)',
            $table->getName(),
            \implode(',', $columns)
        );
    }

    /**
     * Get queries to add/modify columns
     *
     * @throws DatabaseException
     */
    private function getAlterTableQueries(Table $table): array
    {
        $queries = [];

        foreach ($table->getSchema() as $name => $column) {
            if (!$column instanceof ColumnInterface) {
                throw new DatabaseException('Invalid column ' . $name);
            }

            $queries[] = \sprintf(
                'ALTER TABLE %s ADD COLUMN IF NOT EXISTS %s %s',
                $table->getName(),
                $name,
                $column->getDefinition()
            );

            $queries[] = \sprintf(
                'ALTER TABLE %s MODIFY COLUMN %s %s',
                $table->getName(),
                $name,
                $column->getDefinition()
            );
        }

        return $queries;
    }

    /**
     * Get get queries to remove columns
     *
     * @throws DatabaseException
     */
    private function getRemoveColumnsQueries(Table $table): array
    {
        $columns = [];
        $data = $this->query->execute('SHOW COLUMNS FROM '. $table->getName());

        foreach ($data as $column) {
            $columns[] = $column['Field'];
        }

        $columnsToRemove = \array_diff(
            $columns,
            \array_keys($table->getSchema())
        );

        $queries = [];
        foreach ($columnsToRemove as $column) {
            $queries[] =  'ALTER TABLE ' . $table->getName() . ' DROP COLUMN ' . $column;
        }

        return $queries;
    }
}