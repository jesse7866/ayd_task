<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Logger extends Model
{
    use HasFactory;

    protected $table = 'loggers';

    public const UPDATED_AT = null;

    /**
     * 原始表
     * @var string
     */
    protected string $originTable = 'loggers';

    public function __construct(array $attributes = [])
    {
        $this->buildTable();
        parent::__construct($attributes);
    }

    /**
     * 通过表后缀创建 model 实例
     *
     * @param $suffix
     * @return Builder
     */
    public static function suffix($suffix = null): Builder
    {
        $instance = new static;
        $instance->buildTable($suffix);

        return $instance->buildTable($suffix)->newQuery();
    }

    /**
     * 构建分表
     * @param string|null $suffix 表后缀，例: table_{$suffix}
     * @return Logger
     */
    public function buildTable(string $suffix = null): Logger
    {
        $suffix = $suffix ?? date('Ymd');
        $newTable = $this->originTable . '_' . $suffix;
        $hasTable = Schema::connection($this->getConnectionName())->hasTable($newTable);

        if (!$hasTable) {
            DB::statement("create table {$newTable} like {$this->originTable}");
            info('创建表成功======', [$newTable]);
        }

        return $this->setTable($newTable);
    }
}
