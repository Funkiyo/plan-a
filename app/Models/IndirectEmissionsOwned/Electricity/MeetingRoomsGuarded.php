<?php
namespace App\Models\IndirectEmissionsOwned\Electricity;
use Illuminate\Database\Eloquent\Model;
class MeetingRoomsGuarded extends Model
{
    const TABLE_NAME = 'meeting-rooms-guarded';
    protected $guarded = ['*'];
    public function getTableName(): string
    {
        return self::TABLE_NAME;
    }
}
