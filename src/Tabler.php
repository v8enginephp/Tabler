<?php

namespace V8;

define("COLUMN_PROPERTY", "prop");
define("COLUMN_META", "meta");

/**
 * Trait HasTable
 * @package Module\Table
 * @need Jquery Datatable
 */
trait Tabler
{
    private static array $items;

    private static function table()
    {
        return self::$items ?? self::initialize();
    }

    protected static function getTableView()
    {
        return file_get_contents(__DIR__ . "/views/table.tpl");
    }

    private static function initialize()
    {
        return self::$items = static::getDefaultColumns();
    }

    public static function addTableColumn($slug, $title, $data, $permission = null, $priority = 0)
    {
        if (!self::checkColumnData($data))
            throw new \Exception("Unsupported {$slug} Column Data");
        self::table();
        self::$items[] = compact("slug", "title", "data", "permission", "priority");
    }

    public static function getTableColumns()
    {
        return self::table();
    }

    private static function checkColumnData($data)
    {
        return $data == COLUMN_PROPERTY or $data == COLUMN_META or is_callable($data);
    }

    private static function getData($column, $model)
    {
        return $column["data"] == COLUMN_PROPERTY ?
            $model->{$column["slug"]} :
            ($column["data"] == COLUMN_META ?
                @$model->getMeta($column["slug"])->value :
                $column["data"]($model));
    }

    public static function renderTable($records, $id = null, $datatable = false)
    {
        $id = $id ? $id : str_replace("\\", "_", static::class);

        $table = self::getTableView();

        $table = str_replace(["{ID}", "{HEADER}", "{BODY}", '{DATATABLE}'], [$id, self::renderTableHeader(), self::renderTableBody($records), $datatable ? "1" : "0"], $table);

        return $table;
    }

//    public static function deleteTableColumn($slug)
//    {
//        $table = self::table();
//        if (is_array($slug))
//            self::$items = $table->whereNotIn('slug', $slug);
//        else
//            self::$items = $table->where('slug', "!=", $slug);
//    }

    private static function renderTableHeader()
    {
        $header = '';
        foreach (self::table() as $column) {
            if (self::condition($column))
                $header .= "<th id='{$column['slug']}'>{$column['title']}</th>";
        }
        return $header;
    }

    public function renderRow($column, $record)
    {
        if (self::condition($column))
            return "<td class='{$column['slug']}'>" . self::getData($column, $record) . "</td>";
        return null;
    }

    private static function renderTableBody($records)
    {
        $body = "";
        foreach ($records as $record) {
            /**
             * @var Tabler $record
             */
            $body .= "<tr class='t-row' data-row='$record->id'>";
            foreach (self::table() as $column) {
                $body .= $record->renderRow($column, $record);
            }
            $body .= "</tr>";
        }
        return $body;
    }

    protected static function getDefaultColumns(): array
    {
        return [];
    }

    private static function condition($column)
    {
        return true;
    }
}