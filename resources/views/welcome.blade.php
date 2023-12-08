<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Redshift</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div style="max-width: 600px; display: flex;">
        <canvas id="genderChart"></canvas>
        <canvas id="ageHistogram"></canvas>
    </div>

    <script>
        var genderCounts = @json($genderCounts);
        var ageCounts = @json($ageCounts);

        // 性別比率の円グラフ
        var genderCtx = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: genderCounts.map(g => g.gender),
                datasets: [{
                    label: 'Gender Ratio',
                    data: genderCounts.map(g => g.count),
                    backgroundColor: ['blue', 'pink', 'green'],
                }]
            }
        });

        // 年齢層のヒストグラム
        var ageCtx = document.getElementById('ageHistogram').getContext('2d');
        var ageHistogram = new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: ageCounts.map(a => a.age),
                datasets: [{
                    label: 'Age Distribution',
                    data: ageCounts.map(a => a.count),
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

</html>
