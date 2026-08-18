@extends('adminpanel.layouts.app')
@section('title', 'Ticket Statistics by Service')

@section('content')
<div class="content flex-row-fluid" id="kt_content">
    {{-- Hidden lang keys for JS to read --}}
    <span class="d-none" id="lang-chart-title"    data-lang="menu::Ticket Statistics by Service">Thống kê phiếu hỗ trợ theo dịch vụ</span>
    <span class="d-none" id="lang-cancel"         data-lang="\/tickets::Cancel">Cancel</span>
    <span class="d-none" id="lang-refill"         data-lang="\/tickets::Refill">Refill</span>
    <span class="d-none" id="lang-speedup"        data-lang="\/tickets::Speed up">Speed up</span>
    <span class="d-none" id="lang-apply"          data-lang="button::Apply">Áp dụng</span>
    <span class="d-none" id="lang-cancel-btn"     data-lang="button::Cancel">Hủy</span>
    <span class="d-none" id="lang-custom-range"   data-lang="calendar::Custom Range">Lựa chọn</span>
    <span class="d-none" id="lang-today"          data-lang="calendar::Today">Hôm nay</span>
    <span class="d-none" id="lang-yesterday"      data-lang="calendar::Yesterday">Hôm qua</span>
    <span class="d-none" id="lang-last7"          data-lang="calendar::Last 7 days">7 ngày gần nhất</span>
    <span class="d-none" id="lang-last30"         data-lang="calendar::Last 30 days">30 ngày gần nhất</span>
    <span class="d-none" id="lang-this-month"     data-lang="calendar::This month">Tháng này</span>
    <span class="d-none" id="lang-last-month"     data-lang="calendar::Last month">Tháng trước</span>

    <div class="d-flex align-items-center justify-content-end mb-5">
        <div class="input-group input-group-sm w-250px">
            <span class="input-group-text"><i class="las la-calendar fs-2"></i></span>
            <input class="form-control text-center ipt-date" value="{{ $startDate }} - {{ $endDate }}" readonly>
        </div>
    </div>
    <div class="card card-flush shadow-sm">
        <div class="card-body p-4">
            <div id="ticketChartWrap" style="position:relative; width:100%; min-height:300px;">
                <canvas id="ticketChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var chartData  = @json($data);
    var startDate  = '{{ $startDate }}';
    var endDate    = '{{ $endDate }}';
    var chartInst  = null;

    function L(id) {
        var el = document.getElementById(id);
        return el ? el.textContent.trim() : '';
    }

    function buildChart(data) {
        var labels  = Object.keys(data);
        var cancel  = labels.map(function(k){ return data[k].cancel; });
        var refill  = labels.map(function(k){ return data[k].refill; });
        var speedup = labels.map(function(k){ return data[k].speedup; });

        var rowH = 28;
        var wrap = document.getElementById('ticketChartWrap');
        wrap.style.height = Math.max(400, labels.length * (rowH + 12) + 80) + 'px';

        var ctx = document.getElementById('ticketChart').getContext('2d');
        if (chartInst) chartInst.destroy();

        chartInst = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: L('lang-cancel'),  data: cancel,  backgroundColor: '#f6c000', barThickness: rowH - 4 },
                    { label: L('lang-refill'),  data: refill,  backgroundColor: '#6f42c1', barThickness: rowH - 4 },
                    { label: L('lang-speedup'), data: speedup, backgroundColor: '#2d7be5', barThickness: rowH - 4 },
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: L('lang-chart-title'),
                        font: { size: 14 }
                    },
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { stacked: true, beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#eee' } },
                    y: { stacked: true, grid: { display: false } }
                }
            }
        });
    }

    function loadData(start, end) {
        fetch('/admin/ticket_statistics_by_service?start=' + start + '&end=' + end, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(function(r){ return r.json(); })
        .then(function(json){ buildChart(json.data); })
        .catch(function(){ buildChart(chartData); });
    }

    window._ticket_statistics_by_service = {
        init: function () {
            buildChart(chartData);

            var $ipt = jQuery('.ipt-date');
            if ($ipt.length && jQuery.fn.daterangepicker) {
                $ipt.daterangepicker({
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: 'YYYY/MM/DD',
                        applyLabel:       L('lang-apply'),
                        cancelLabel:      L('lang-cancel-btn'),
                        customRangeLabel: L('lang-custom-range'),
                    },
                    ranges: (function(){
                        var r = {};
                        r[L('lang-today')]      = [moment(), moment()];
                        r[L('lang-yesterday')]  = [moment().subtract(1,'days'), moment().subtract(1,'days')];
                        r[L('lang-last7')]      = [moment().subtract(6,'days'), moment()];
                        r[L('lang-last30')]     = [moment().subtract(29,'days'), moment()];
                        r[L('lang-this-month')] = [moment().startOf('month'), moment().endOf('month')];
                        r[L('lang-last-month')] = [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')];
                        return r;
                    })()
                }, function (s, e) {
                    loadData(s.format('YYYY-MM-DD'), e.format('YYYY-MM-DD'));
                });
            }
        }
    };

    // Load Chart.js if not present, then init
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Chart === 'undefined') {
            var s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/chart.js';
            s.onload = function () { _ticket_statistics_by_service.init(); };
            document.head.appendChild(s);
        } else {
            _ticket_statistics_by_service.init();
        }
    });
})();
</script>
@endsection
