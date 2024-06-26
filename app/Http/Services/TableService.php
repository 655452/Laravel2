<?php


namespace App\Http\Services;


use App\Enums\TableStatus;
use App\Enums\UserRole;
use App\Models\Table;
use Illuminate\Http\Request;

class TableService
{
    public function allTables($request)
    {
        $q = trim($request->id);
        $queryArray = [];
        if (auth()->user()->myrole == UserRole::WAITER) {
            $queryArray['restaurant_id'] = auth()->user()->waiter->restaurant->id;
        } else {
            $queryArray['restaurant_id'] = auth()->user()->restaurant ? auth()->user()->restaurant->id : [];
        }


        if ($q) {
            $this->data['tables'] = Table::where($queryArray)->where('name', 'like', '%' . $q . '%')->where('status', TableStatus::ENABLE)->descending()->get();
        } else {
            $this->data['tables'] = Table::where($queryArray)->where('status', TableStatus::ENABLE)->descending()->get();
        }

        return $this->data['tables'];
    }

    public function store(Request $request)
    {
        $table           = new Table;
        $table->name     = $request->name;
        $table->capacity = $request->capacity;
        $table->status   = $request->status;
        $table->restaurant_id     = $request->restaurant_id;
        $table->save();

        return $table;
    }



    public function update(Request $request, $table) : void
    {
        $table->name     = $request->name;
        $table->capacity = $request->capacity;
        $table->restaurant_id     = $request->restaurant_id;
        $table->status   = $request->status;
        $table->save();
    }

    public function delete($table)
    {
        $table->delete();
    }

}
