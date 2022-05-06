<div style="display: flex; width; 100%; justify-content: center;flex-wrap:wrap;" wire:poll>

    <div class="revenue-radio-container" style="border-radius: 15px;
    box-shadow: inset 2px 2px 2px #cbced1, inset -2px -2px 2px #eee">
        <ul class="revenue-radio-lists" style="display: flex; width; 100%; list-style: none;padding-left: 0; height: 40px">
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center;">
                <input type="radio" value="0" wire:model="types" class="revenue-radio-item" name="revenue-radio" id="daily-radio" wire:click="cekOmbak"
                @if ($types == 0)
                    checked
                @endif
                hidden/>
                <label for="daily-radio" style="margin: 0; padding: 0; cursor: pointer">daily</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="1" wire:model="types" class="revenue-radio-item" name="revenue-radio" id="weekly-radio" wire:click="cekOmbak"
                @if ($types == 1)
                    checked
                @endif
                hidden/>
                <label for="weekly-radio" style="margin: 0; padding: 0; cursor: pointer">weekly</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="2" wire:model="types" class="revenue-radio-item" name="revenue-radio" id="monthly-radio" wire:click="cekOmbak"
                @if ($types == 2)
                    checked
                @endif
                hidden/>
                <label for="monthly-radio" style="margin: 0; padding: 0; cursor: pointer">monthly</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="3" wire:model="types" class="revenue-radio-item" name="revenue-radio" id="yearly-radio" wire:click="cekOmbak"
                @if ($types == 3)
                    checked
                @endif
                hidden/>
                <label for="yearly-radio" style="margin: 0; padding: 0; cursor: pointer">yearly</label>
            </li>
            <li class="mx-4" style="padding: 0; margin: 0; display:flex; align-items: center">
                <input type="radio" value="4" wire:model="types" class="revenue-radio-item" name="revenue-radio" id="all-radio" wire:click="cekOmbak"
                @if ($types == 4)
                    checked
                @endif
                hidden/>
                <label for="all-radio" style="margin: 0; padding: 0; cursor: pointer">all time</label>
            </li>
        </ul>
    </div>

    <div class="break"></div>

    <div style="display:flex ;width: 100%; justify-content:center; margin-top: 3rem">
        <h1>Pendapatan Total :</h1>
    </div>

    <div class="break"></div>

    <h1>Rp. {{number_format($omset)}}</h1>

    <div class="break"></div>

    <div style="width: 100%; margin-top: 5rem;">
        <ul>
            @foreach ($storeRevenue as $value)
            <li class="media" style="display: flex; align-items: center; animation-duration: 0.5s">
                <svg xmlns="http://www.w3.org/2000/svg" style="fill: #7cd4f2; height: 50px; width: auto; padding-right: 15px;" viewBox="0 0 1811.34 1472.28"><title>Asset 1</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M1811.34,481.34c-2.25,8.35-4.65,16.66-6.72,25.05-26.67,108.3-127,181.24-238.12,172.26-53.58-4.32-99.85-25.91-138.74-63.12l-12.69-12.14c-46.18,48.4-101.92,75.72-169.06,75.89s-123.29-26.58-170.44-76.12c-46.51,48.83-102.32,76-169.48,76.12s-123.23-26.73-170.22-76.17c-46.63,49.12-102.54,76.14-169.7,76.15S442.91,652.62,396.8,603.53C386.09,613,376.86,622,366.82,630,239.55,731.09,51.42,670.06,7.62,510.74,4.36,498.87,2.56,486.53.87,474.3c-3.2-23.18,2.48-44.52,16-63.43Q152.3,220.82,288,30.92C302.84,10,321.91,0,347.82,0Q905.94.38,1464.05,0c25.17,0,44,9.68,58.5,30q135.95,190.79,272,381.48c7.29,10.27,11.25,22.9,16.75,34.43Z"/><path d="M1415.48,747.13c90,48.63,183.19,59.46,281.36,25.3.51,5,1.23,8.82,1.24,12.63q.08,283.92,0,567.82c0,48.52-20.5,85.68-64.43,107.12-14.36,7-31.51,10.63-47.58,11.37-35.89,1.66-71.91.55-107.88.49-1.63,0-3.26-.74-6.06-1.42V907.18H1132.32V1472h-17.26q-439.57,0-879.14.09c-49.78,0-87.85-19.28-111.12-64.25-9.4-18.18-11.78-38-11.76-58.33q.17-179.55,0-359.09V770.63c48.36,16.07,96.47,22.08,145.45,18.37a325.19,325.19,0,0,0,137-41.86C509.1,805.54,622,806,735.72,747.42q169,87.51,339.69,0C1188.26,805.51,1301.15,806,1415.48,747.13ZM340.31,1244.34H791V906.81H340.31Z"/></g></g></svg>
                <div class="media-body" style="height: 100%">
                  <div class="float-right text-primary" style="float-right; font-size: 1.2rem;">Rp.&nbsp;{{number_format($value->total_revenue)}}</div>
                    <div class="media-title" style="font-size: 1.2rem;">{{$stores->where('menu_store', $value->menu_store)->first()->nama_store}}</div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</div>
