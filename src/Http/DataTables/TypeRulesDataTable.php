<?php

/*
 * This file is part of SeAT
 *
 * Copyright (C) 2015 to 2021 Leon Jacobs
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace CryptaTech\Seat\SeatSrp\Http\DataTables;

use CryptaTech\Seat\SeatSrp\Models\AdvRule;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Services\DataTable;

/**
 * Class MembersDataTable.
 *
 * @package Seat\Web\Http\DataTables\Squads
 */
class TypeRulesDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(): JsonResponse
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('type', function ($row) {
                // dd($row->type);
                return view('web::partials.type', ['type_id' => $row->type_id, 'type_name' => $row->type->typeName])->render();
            })
            ->editColumn('action', function ($row) {
                // dd($row);
                return view('srp::buttons.ruleremove', compact('row'))->render();
            })
            ->editColumn('deduct_insurance', function ($row) {
                return $row->deduct_insurance > 0 ? 'Yes' : 'No';
            })
            ->editColumn('price_source', function ($row) {
                return $row->priceProviderInstance->name;
            })
            ->rawColumns(['type', 'action'])
            ->toJson();
    }

    /**
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->postAjax()
            ->columns($this->columns())
            ->parameters([
                'drawCallback' => 'function() { $("[data-toggle=tooltip]").tooltip(); }',
            ])
            ->addAction();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return AdvRule::with('priceProviderInstance')->where('rule_type', 'type');
    }

    /**
     * @return array
     */
    public function columns()
    {
        return [
            // ['data' => 'type', 'title' => 'Type'],
            ['data' => 'price_source', 'title' => 'Price Source'],
            ['data' => 'base_value', 'title' => 'Base Value'],
            ['data' => 'hull_percent', 'title' => 'Hull Percent'],
            ['data' => 'fit_percent', 'title' => 'Fit Percent'],
            ['data' => 'cargo_percent', 'title' => 'Cargo Percent'],
            ['data' => 'srp_price_cap', 'title' => 'Price Cap'],
            ['data' => 'deduct_insurance', 'title' => 'Insurance Deducted'],
        ];
    }
}
