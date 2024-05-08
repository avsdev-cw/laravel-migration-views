<?php

namespace Staudenmeir\LaravelMigrationViews\Schema\Grammars;

trait CompilesViews
{
    /**
     * Compile the query to create a view.
     *
     * @param string $name
     * @param string $query
     * @param array|null $columns
     * @param bool $orReplace
     * @param bool $materialized
     * @return string
     */
    public function compileCreateView($name, $query, $columns, $orReplace, bool $materialized = false)
    {
        $orReplaceSql = $orReplace ? 'or replace ' : '';

        $materializedSql = $materialized ? 'materialized ' : '';

        $columns = $columns ? '('.$this->columnize($columns).') ' : '';

        return 'create '.$orReplaceSql.$materializedSql.'view '.$this->wrapTable($name).' '.$columns.'as '.$query;
    }

    /**
     * Compile the query to drop a view.
     *
     * @param string $name
     * @param bool $ifExists
     * @return string
     */
    public function compileDropView($name, $ifExists, bool $materialized = false)
    {
        $ifExists = $ifExists ? 'if exists ' : '';

        $materializedSql = $materialized ? 'materialized ' : '';

        return 'drop '.$materializedSql.'view '.$ifExists.$this->wrapTable($name);
    }

    /**
     * Compile the query to determine if a view exists.
     *
     * @return string
     */
    public function compileViewExists()
    {
        return 'select * from information_schema.views where table_schema = ? and table_name = ?';
    }

    /**
     * Compile the query to refresh a materialized view.
     *
     * @param string $name
     * @return string
     */
    public function compileRefreshMaterializedView(string $name): string
    {
        return 'refresh materialized view ' . $this->wrapTable($name);
    }
}
