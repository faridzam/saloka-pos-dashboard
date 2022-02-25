<canvas class="col-lg-8" id="storeDevelopment"></canvas>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        //line
      var ctxL = document.getElementById("storeDevelopment").getContext('2d');
      var myLineChart = new Chart(ctxL, {
      type: 'line',
      data: {
      labels: ["{{ $monthName[5] }}", "{{ $monthName[4] }}", "{{ $monthName[3] }}", "{{ $monthName[2] }}", "{{ $monthName[1] }}", "{{ $monthName[0] }}"],
      datasets: [{
    
        label: "Kedai Adu Tangkas",
        data: [{{ $profitAduTangkas[0] }}, {{ $profitAduTangkas[1] }}, {{ $profitAduTangkas[2] }}, {{ $profitAduTangkas[3] }}, {{ $profitAduTangkas[4] }}, {{ $profitAduTangkas[5] }}, {{ $profitAduTangkas[6] }}],
        backgroundColor: [
          'rgba(105, 0, 132, .2)',
        ],
        borderColor: [
          'rgba(200, 99, 132, .7)',
        ],
        borderWidth: 2
        },
        
        {
        label: "Shop89",
        data: [{{ $profit89[0] }}, {{ $profit89[1] }}, {{ $profit89[2] }}, {{ $profit89[3] }}, {{ $profit89[4] }}, {{ $profit89[5] }}, {{ $profit89[6] }}],
        backgroundColor: [
          'rgba(0, 119, 182, .2)',
        ],
        borderColor: [
          'rgba(3, 83, 164, .7)',
        ],
        borderWidth: 2
        },
        
        {
        label: "Food Truck Ararya",
        data: [{{ $profitKingdom[0] }}, {{ $profitKingdom[1] }}, {{ $profitKingdom[2] }}, {{ $profitKingdom[3] }}, {{ $profitKingdom[4] }}, {{ $profitKingdom[5] }}, {{ $profitKingdom[6] }}],
        backgroundColor: [
          'rgba(249, 211, 113, 0.2)',
        ],
        borderColor: [
          'rgba(244, 115, 64, 0.7)',
        ],
        borderWidth: 2
        },
        
      ]},
      options: {
      responsive: true
      }
      });
    </script>
    
@endpush