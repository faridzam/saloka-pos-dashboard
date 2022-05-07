<div style="display: flex; width; 100%; justify-content: center;flex-wrap:wrap;">

    <div class="item_sales-radio-container" style="border-radius: 15px;
    box-shadow: inset 2px 2px 2px #cbced1, inset -2px -2px 2px #eee">
        <ul class="item_sales-radio-lists" style="display: flex; width; 100%; list-style: none;padding-left: 0; height: 40px">
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center;">
                <input type="radio" value="0" wire:model="itemSalesOption" class="item_sales-radio-item" name="item_sales-radio" id="daily-item-sales" wire:click="changeItemSalesOption"
                @if ($itemSalesOption == 0)
                    checked
                @endif
                hidden/>
                <label for="daily-item-sales" style="margin: 0; padding: 0; cursor: pointer">daily</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="1" wire:model="itemSalesOption" class="item_sales-radio-item" name="item_sales-radio" id="weekly-item-sales" wire:click="changeItemSalesOption"
                @if ($itemSalesOption == 1)
                    checked
                @endif
                hidden/>
                <label for="weekly-item-sales" style="margin: 0; padding: 0; cursor: pointer">weekly</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="2" wire:model="itemSalesOption" class="item_sales-radio-item" name="item_sales-radio" id="monthly-item-sales" wire:click="changeItemSalesOption"
                @if ($itemSalesOption == 2)
                    checked
                @endif
                hidden/>
                <label for="monthly-item-sales" style="margin: 0; padding: 0; cursor: pointer">monthly</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="3" wire:model="itemSalesOption" class="item_sales-radio-item" name="item_sales-radio" id="yearly-item-sales" wire:click="changeItemSalesOption"
                @if ($itemSalesOption == 3)
                    checked
                @endif
                hidden/>
                <label for="yearly-item-sales" style="margin: 0; padding: 0; cursor: pointer">yearly</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="4" wire:model="itemSalesOption" class="item_sales-radio-item" name="item_sales-radio" id="all-item-sales" wire:click="changeItemSalesOption"
                @if ($itemSalesOption == 4)
                    checked
                @endif
                hidden/>
                <label for="all-item-sales" style="margin: 0; padding: 0; cursor: pointer">all time</label>
            </li>
        </ul>
    </div>

    <div class="break"></div>

    <div style="width: 100%; margin-top: 5rem;">
        <ul>
            @foreach ($storeItemSales as $value)
            <li class="media" style="display: flex; align-items: center; animation-duration: 0.5s; border-bottom: solid 1px #6777ef">
                <div class="media-body" style="height: 100%;">
                    <div class="float-right text-primary" style="float-right; font-size: 1.2rem;" wire:poll>{{number_format($value->total_quantities)}}&nbsp;pcs</div>
                    <div class="media-title" style="font-size: 1.2rem;">{{$items->where('id_item', $value->id_item)->first()->nama_item}}</div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</div>
